<?php

namespace App\Filament\Admin\Resources\QuizSubmissionResource\Pages;

use App\Filament\Admin\Resources\QuizSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuizSubmission extends EditRecord
{
    protected static string $resource = QuizSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
