<?php

namespace App\Filament\Admin\Resources\AnnouncementCommentResource\Pages;

use App\Filament\Admin\Resources\AnnouncementCommentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnnouncementComment extends EditRecord
{
    protected static string $resource = AnnouncementCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
