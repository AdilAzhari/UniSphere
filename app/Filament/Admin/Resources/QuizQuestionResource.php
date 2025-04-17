<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\QuizQuestionResource\Pages;
use App\Models\QuizQuestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuizQuestionResource extends Resource
{
    protected static ?string $model = QuizQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Quiz Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Question Details')
                            ->schema([
                                Forms\Components\Select::make('quiz_id')
                                    ->relationship('quiz', 'title')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->maxLength(255),
                                    ]),

                                Forms\Components\RichEditor::make('question')
                                    ->required()
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'bulletList',
                                        'orderedList',
                                    ])
                                    ->columnSpanFull(),

                                //                                Forms\Components\Toggle::make('is_active')
                                //                                    ->label('Active')
                                //                                    ->default(true)
                                //                                    ->helperText('Inactive questions won\'t appear in quizzes'),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->searchable()
                    ->limit(50)
                    ->html(),

                Tables\Columns\TextColumn::make('quiz.title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('createdBy.user.name')
                    ->label('Created By')
                    ->sortable()
                    ->toggleable(),

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
                Tables\Filters\SelectFilter::make('quiz')
                    ->relationship('quiz', 'title')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All Questions')
                    ->trueLabel('Active Questions')
                    ->falseLabel('Inactive Questions'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('toggleActive')
                        ->label('Toggle Active Status')
                        ->icon('heroicon-o-power')
                        ->action(function (Collection $records): void {
                            $records->each(function ($record): void {
                                $record->update(['is_active' => ! $record->is_active]);
                            });
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            // Add relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizQuestions::route('/'),
            'create' => Pages\CreateQuizQuestion::route('/create'),
            'edit' => Pages\EditQuizQuestion::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes();
    }
}
