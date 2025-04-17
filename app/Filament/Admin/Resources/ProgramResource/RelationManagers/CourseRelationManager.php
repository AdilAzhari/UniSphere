<?php

namespace App\Filament\Admin\Resources\ProgramResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CourseRelationManager extends RelationManager
{
    protected static string $relationship = 'courses';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No courses yet') // Custom heading for the empty state
            ->emptyStateDescription('Once you add a course, it will appear here.') // Custom description for the empty state
            ->emptyStateIcon('heroicon-o-bookmark') // Custom icon for the empty state
            ->emptyStateActions([
                Tables\Actions\Action::make('create')
                    ->label('Create course')
                    ->url(route('filament.admin.resources.programs.create'))
                    ->icon('heroicon-o-plus')
                    ->button(),
            ]);
    }
}
