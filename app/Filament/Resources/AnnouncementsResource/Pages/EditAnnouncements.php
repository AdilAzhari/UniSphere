<?php

namespace App\Filament\Admin\Resources\AnnouncementsResource\Pages;

use App\Filament\Admin\Resources\AnnouncementsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnnouncements extends EditRecord
{
    //    protected static string $resource = AnnouncementsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
