<?php

namespace App\Filament\Admin\Resources\QuizQuestionOptionResource\Pages;

use App\Filament\Admin\Resources\QuizQuestionOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuizQuestionOptions extends ListRecords
{
    protected static string $resource = QuizQuestionOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
