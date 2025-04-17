<?php

namespace App\Filament\Admin\Resources\AcademicProgressResource\Pages;

use App\Filament\Admin\Resources\AcademicProgressResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAcademicProgress extends ListRecords
{
    protected static string $resource = AcademicProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
