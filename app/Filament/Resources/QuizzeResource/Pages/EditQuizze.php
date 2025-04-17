<?php

namespace App\Filament\Admin\Resources\QuizzeResource\Pages;

use App\Filament\Admin\Resources\QuizResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuizze extends EditRecord
{
    protected static string $resource = QuizResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
