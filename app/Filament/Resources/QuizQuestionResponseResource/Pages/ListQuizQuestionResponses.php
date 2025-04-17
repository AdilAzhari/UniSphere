<?php

namespace App\Filament\Admin\Resources\QuizQuestionResponseResource\Pages;

use App\Filament\Admin\Resources\QuizQuestionResponseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuizQuestionResponses extends ListRecords
{
    protected static string $resource = QuizQuestionResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
