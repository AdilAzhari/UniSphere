<?php

namespace App\Filament\Admin\Resources\ExamAnswerResource\Pages;

use App\Filament\Admin\Resources\ExamAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExamAnswers extends ListRecords
{
    protected static string $resource = ExamAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
