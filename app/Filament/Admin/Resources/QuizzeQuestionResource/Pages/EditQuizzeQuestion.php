<?php

namespace App\Filament\Admin\Resources\QuizzeQuestionResource\Pages;

use App\Filament\Admin\Resources\QuizzeQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuizzeQuestion extends EditRecord
{
    protected static string $resource = QuizzeQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
