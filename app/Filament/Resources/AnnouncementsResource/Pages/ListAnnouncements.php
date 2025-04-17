<?php

namespace App\Filament\Admin\Resources\AnnouncementsResource\Pages;

use App\Filament\Admin\Resources\AnnouncementsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnnouncements extends ListRecords
{
    //    protected static string $resource = AnnouncementsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
