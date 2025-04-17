<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class SetupRoleBasedPanels extends Command
{
    protected $signature = 'app:setup-role-panels';
    protected $description = 'Create Filament panels for all user roles';

    public function handle(): void
    {
        $this->components->info('Setting up role-based panels...');

        foreach (UserRole::cases() as $role) {
            $panelSlug = Str::lower(Str::slug($role->value));

            $this->components->task("Creating {$role->value} panel", function() use ($panelSlug, $role) {
                // Create panel
                Artisan::call('make:filament-panel', [
                    'name' => $panelSlug,
                    '--quiet' => true
                ]);

                // Create default resources
                $this->createRoleResources($panelSlug, $role);

                // Configure panel
                $this->configurePanel($panelSlug, $role->value);

                return true;
            });
        }

        $this->components->info('All panels created successfully!');
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
                '--quiet' => true
            ]);
        }
    }

    protected function configurePanel(string $panelSlug, string $roleName)
    {
        $configPath = config_path("filament/{$panelSlug}.php");

        $configContent = <<<PHP
        <?php

        use App\Enums\UserRole;
        use Filament\Panel;

        return [
            'id' => '{$panelSlug}',
            'path' => '{$panelSlug}',
            'login' => [
                'title' => '{$roleName} Login',
            ],
            'brandName' => '{$roleName} Portal',
            'auth' => [
                'guard' => 'web',
                'middleware' => [
                    'web',
                    'auth',
                    \App\Http\Middleware\VerifyIs{$roleName}::class,
                ],
            ],
        ];
        PHP;

        file_put_contents($configPath, $configContent);
    }
}
