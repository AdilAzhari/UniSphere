<?php

namespace App\Filament\Admin\Resources\ProgramAdvisorResource\Pages;

use App\Filament\Admin\Resources\ProgramAdvisorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProgramAdvisors extends ListRecords
{
    protected static string $resource = ProgramAdvisorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
