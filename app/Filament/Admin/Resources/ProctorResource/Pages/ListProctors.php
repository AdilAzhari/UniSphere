<?php

namespace App\Filament\Admin\Resources\ProctorResource\Pages;

use App\Filament\Admin\Resources\ProctorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProctors extends ListRecords
{
    protected static string $resource = ProctorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
