<?php

namespace App\Filament\Admin\Resources\QuizQuestionResponsesResource\Pages;

use App\Filament\Admin\Resources\QuizQuestionResponsesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuizQuestionResponses extends ListRecords
{
    protected static string $resource = QuizQuestionResponsesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
