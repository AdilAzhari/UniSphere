<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\QuizQuestionOptionResource\Pages;
use App\Models\QuizQuestionOption;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class QuizQuestionOptionResource extends Resource
{
    protected static ?string $model = QuizQuestionOption::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $navigationGroup = 'Quiz Management';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Question Option';

    protected static ?string $pluralModelLabel = 'Question Options';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Select::make('quiz_question_id')
                            ->label('Question')
                            ->relationship(
                                'quizQuestion',
                                'question',
                                fn (Builder $query) => $query->latest()
                            )
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull()
                            ->helperText('Select the question this option belongs to'),

                        Forms\Components\TextInput::make('option')
                            ->label('Answer Option')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Enter the answer option text'),

                        Forms\Components\Toggle::make('is_correct')
                            ->label('Correct Answer')
                            ->required()
                            ->helperText('Is this the correct answer?')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('quizQuestion.question')
                    ->label('Question')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(50),

                Tables\Columns\TextColumn::make('option')
                    ->label('Answer Option')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(50),

                Tables\Columns\IconColumn::make('is_correct')
                    ->label('Correct')
                    ->boolean()
                    ->sortable()
                    ->alignCenter()
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger'),

                Tables\Columns\TextColumn::make('createdBy.user.name')
                    ->label('Created By')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updatedBy.user.name')
                    ->label('Updated By')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Deleted')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->label('Show Deleted Options'),

                Tables\Filters\SelectFilter::make('quiz_question_id')
                    ->label('Filter by Question')
                    ->relationship('quizQuestion', 'question')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                Tables\Filters\TernaryFilter::make('is_correct')
                    ->label('Correct Answer Status')
                    ->placeholder('All Options')
                    ->trueLabel('Correct Answers')
                    ->falseLabel('Incorrect Answers'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\BulkAction::make('toggleCorrect')
                        ->label('Toggle Correct Status')
                        ->icon('heroicon-o-check-circle')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $records->each(function ($record): void {
                                $record->update(['is_correct' => ! $record->is_correct]);
                            });
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->persistSortInSession()
            ->persistFiltersInSession()
            ->persistSearchInSession();
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
            'index' => Pages\ListQuizQuestionOptions::route('/'),
            'create' => Pages\CreateQuizQuestionOption::route('/create'),
            'edit' => Pages\EditQuizQuestionOption::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->count();
    }
}
