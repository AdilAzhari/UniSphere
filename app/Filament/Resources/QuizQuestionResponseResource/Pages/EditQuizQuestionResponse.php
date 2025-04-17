<?php

namespace App\Filament\Admin\Resources\QuizQuestionResponseResource\Pages;

use App\Filament\Admin\Resources\QuizQuestionResponseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuizQuestionResponse extends EditRecord
{
    protected static string $resource = QuizQuestionResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
