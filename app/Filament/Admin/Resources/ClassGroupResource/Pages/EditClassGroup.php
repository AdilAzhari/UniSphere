<?php

namespace App\Filament\Admin\Resources\ClassGroupResource\Pages;

use App\Filament\Admin\Resources\ClassGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClassGroup extends EditRecord
{
    protected static string $resource = ClassGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
