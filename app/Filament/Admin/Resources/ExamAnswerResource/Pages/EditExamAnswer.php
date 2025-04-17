<?php

namespace App\Filament\Admin\Resources\ExamAnswerResource\Pages;

use App\Filament\Admin\Resources\ExamAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExamAnswer extends EditRecord
{
    protected static string $resource = ExamAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
