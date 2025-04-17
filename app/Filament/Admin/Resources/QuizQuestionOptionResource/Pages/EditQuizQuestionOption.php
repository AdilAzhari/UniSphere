<?php

namespace App\Filament\Admin\Resources\QuizQuestionOptionResource\Pages;

use App\Filament\Admin\Resources\QuizQuestionOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuizQuestionOption extends EditRecord
{
    protected static string $resource = QuizQuestionOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
