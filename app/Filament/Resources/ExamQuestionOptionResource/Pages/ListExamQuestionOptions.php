<?php

namespace App\Filament\Admin\Resources\ExamQuestionOptionResource\Pages;

use App\Filament\Admin\Resources\ExamQuestionOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExamQuestionOptions extends ListRecords
{
    protected static string $resource = ExamQuestionOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
