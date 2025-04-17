<?php

namespace App\Filament\Admin\Resources\QuizQuestionResource\Pages;

use App\Filament\Admin\Resources\QuizQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuizQuestions extends ListRecords
{
    protected static string $resource = QuizQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
