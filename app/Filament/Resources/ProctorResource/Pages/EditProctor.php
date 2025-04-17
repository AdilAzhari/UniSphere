<?php

namespace App\Filament\Admin\Resources\ProctorResource\Pages;

use App\Filament\Admin\Resources\ProctorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProctor extends EditRecord
{
    protected static string $resource = ProctorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
