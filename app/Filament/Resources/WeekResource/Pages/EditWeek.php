<?php

namespace App\Filament\Admin\Resources\WeekResource\Pages;

use App\Filament\Admin\Resources\WeekResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWeek extends EditRecord
{
    protected static string $resource = WeekResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
