<?php

namespace App\Filament\Admin\Resources\ExamResultResource\Pages;

use App\Filament\Admin\Resources\ExamResultResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExamResults extends ListRecords
{
    protected static string $resource = ExamResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
