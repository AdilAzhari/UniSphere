<?php

namespace App\Filament\Admin\Resources\QuizQuestionResponsesResource\Pages;

use App\Filament\Admin\Resources\QuizQuestionResponsesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuizQuestionResponses extends EditRecord
{
    protected static string $resource = QuizQuestionResponsesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
