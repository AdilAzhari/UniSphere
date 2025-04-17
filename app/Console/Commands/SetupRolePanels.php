<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class SetupRolePanels extends Command
{
    protected $signature = 'app:setup-role-panels';
    protected $description = 'Create Filament panels for all user roles';

    public function handle()
    {
        $this->components->info('Setting up role-based panels...');

        foreach (UserRole::cases() as $role) {
            $panelSlug = Str::kebab($role->value);
            $panelClass = Str::studly($panelSlug).'PanelProvider';

            $this->components->task("Creating {$role->value} panel", function() use ($panelSlug, $role, $panelClass) {
                // 1. Create panel provider
                $this->createPanelProvider($panelSlug, $panelClass);

                // 2. Register panel in config
                $this->registerPanelInConfig($panelSlug, $panelClass);

                // 3. Create default resources
                $this->createRoleResources($panelSlug, $role);

                // 4. Create middleware
                $this->createMiddleware($role->value);

                return true;
            });
        }

        $this->components->info('All panels created successfully!');
        $this->components->info('Run these commands to complete setup:');
        $this->components->bulletList([
            'composer dump-autoload',
            'php artisan migrate:fresh --seed',
            'php artisan optimize'
        ]);
    }

    protected function createPanelProvider(string $panelSlug, string $panelClass)
    {
        $providerPath = app_path("Providers/Filament/{$panelClass}.php");

        if (!File::exists($providerPath)) {
            File::ensureDirectoryExists(dirname($providerPath));

            $stub = File::get(__DIR__.'/../../../stubs/filament-panel-provider.stub');
            $stub = str_replace(['{{panel}}', '{{Panel}}'], [$panelSlug, Str::studly($panelSlug)], $stub);

            File::put($providerPath, $stub);
        }
    }

    protected function registerPanelInConfig(string $panelSlug, string $panelClass)
    {
        $configPath = config_path('filament.php');
        $config = File::get($configPath);

        if (!str_contains($config, $panelClass)) {
            $config = str_replace(
                "'providers' => [",
                "'providers' => [\n\t\t\\App\\Providers\\Filament\\{$panelClass}::class,",
                $config
            );
            File::put($configPath, $config);
        }
    }

    protected function createRoleResources(string $panelSlug, UserRole $role)
    {
        $resources = match($role) {
            UserRole::ADMIN => ['User', 'AuditLog', 'SystemSetting'],
            UserRole::TEACHER => ['Course', 'Lesson', 'Gradebook'],
            UserRole::TECHNICAL_TEAM => ['Tool', 'Equipment', 'Maintenance'],
            UserRole::STUDENT => ['Enrollment', 'Submission', 'Progress'],
        };

        foreach ($resources as $resource) {
            Artisan::call('make:filament-resource', [
                'name' => $resource,
                '--panel' => $panelSlug,
            ]);
        }
    }

    protected function createMiddleware(string $roleName)
    {
        $middlewareName = "VerifyIs{$roleName}";
        $middlewarePath = app_path("Http/Middleware/{$middlewareName}.php");

        if (!File::exists($middlewarePath)) {
            Artisan::call('make:middleware', [
                'name' => $middlewareName
            ]);

            // Update middleware content
            $content = <<<PHP
            <?php

            namespace App\Http\Middleware;

            use App\Enums\UserRole;
            use Closure;
            use Illuminate\Http\Request;
            use Symfony\Component\HttpFoundation\Response;

            class {$middlewareName}
            {
                public function handle(Request \$request, Closure \$next): Response
                {
                    if (\$request->user()?->role !== UserRole::{$roleName}) {
                        abort(403, '{$roleName} access required');
                    }
                    return \$next(\$request);
                }
            }
            PHP;

            File::put($middlewarePath, $content);
        }
    }
}
