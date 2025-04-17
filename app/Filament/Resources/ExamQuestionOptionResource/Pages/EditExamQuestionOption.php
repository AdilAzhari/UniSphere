<?php

namespace App\Filament\Admin\Resources\ExamQuestionOptionResource\Pages;

use App\Filament\Admin\Resources\ExamQuestionOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExamQuestionOption extends EditRecord
{
    protected static string $resource = ExamQuestionOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
