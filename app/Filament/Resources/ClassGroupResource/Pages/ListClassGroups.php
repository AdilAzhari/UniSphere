<?php

namespace App\Filament\Admin\Resources\ClassGroupResource\Pages;

use App\Filament\Admin\Resources\ClassGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClassGroups extends ListRecords
{
    protected static string $resource = ClassGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
