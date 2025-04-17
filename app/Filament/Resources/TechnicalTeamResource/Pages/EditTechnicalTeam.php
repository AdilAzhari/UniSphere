<?php

namespace App\Filament\Admin\Resources\TechnicalTeamResource\Pages;

use App\Filament\Admin\Resources\TechnicalTeamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTechnicalTeam extends EditRecord
{
    protected static string $resource = TechnicalTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
