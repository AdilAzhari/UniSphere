<?php

namespace App\Filament\Admin\Resources\ProgramAdvisorResource\Pages;

use App\Filament\Admin\Resources\ProgramAdvisorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProgramAdvisor extends EditRecord
{
    protected static string $resource = ProgramAdvisorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
