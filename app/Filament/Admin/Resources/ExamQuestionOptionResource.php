<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ExamQuestionOptionResource\Pages;
use App\Models\ExamQuestionOption;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExamQuestionOptionResource extends Resource
{
    protected static ?string $model = ExamQuestionOption::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $navigationGroup = 'Assessment & Grading';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('exam_question_id')
                    ->relationship('question', 'question_text')
                    ->required(),
                Forms\Components\Textarea::make('option_text')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_correct')
                    ->required(),
                Forms\Components\Select::make('created_by')
                    ->relationship('createdBy.user', 'name')
                    ->required(),
                Forms\Components\Select::make('updated_by')
                    ->relationship('updatedBy.user', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question.question_text')
                    ->label('Question')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\IconColumn::make('is_correct')
                    ->label('Correct')
                    ->boolean(),
                Tables\Columns\TextColumn::make('createdBy.user.name')
                    ->label('Created By')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updatedBy.user.name')
                    ->label('Updated By')
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExamQuestionOptions::route('/'),
            'create' => Pages\CreateExamQuestionOption::route('/create'),
            'edit' => Pages\EditExamQuestionOption::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
