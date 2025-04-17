<?php

namespace App\Filament\Admin\Resources\TechnicalTeamResource\Pages;

use App\Filament\Admin\Resources\TechnicalTeamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTechnicalTeams extends ListRecords
{
    protected static string $resource = TechnicalTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
