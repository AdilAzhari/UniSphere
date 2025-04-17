<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\QuizQuestionResponseResource\Pages;
use App\Models\QuizQuestionResponse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuizQuestionResponseResource extends Resource
{
    protected static ?string $model = QuizQuestionResponse::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Quiz Management';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'Student Response';

    protected static ?string $pluralModelLabel = 'Student Responses';

    protected static bool $shouldRegisterNavigation = false; // Hide from navigation as this is managed through relationships

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Response Details')
                    ->schema([
                        Forms\Components\Select::make('quiz_submission_id')
                            ->relationship('quizSubmission', 'id', function (Builder $query) {
                                return $query->with(['student', 'quiz']);
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Quiz Submission')
//                            ->formatStateUsing(fn ($record) => optional($record->quizSubmission)->quiz->title . ' - ' . optional($record->quizSubmission)->student->user->name)
                            ->disabled(),

                        Forms\Components\Select::make('quiz_question_id')
                            ->relationship('quizQuestion', 'question')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Question')
                            ->disabled(),

                        Forms\Components\Select::make('quiz_question_option_id')
                            ->relationship('quizQuestionOption', 'option')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Selected Answer')
                            ->disabled(),

                        Forms\Components\Toggle::make('is_correct')
                            ->label('Correct Answer?')
                            ->required()
                            ->disabled()
                            ->helperText('This is automatically determined based on the selected answer'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('quizSubmission.quiz.title')
                    ->label('Quiz')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('quizSubmission.student.user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('quizQuestion.question')
                    ->label('Question')
                    ->wrap()
                    ->limit(50)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('quizQuestionOption.option')
                    ->label('Selected Answer')
                    ->wrap()
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_correct')
                    ->label('Correct')
                    ->boolean()
                    ->sortable()
                    ->alignCenter()
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('quiz_submission')
                    ->relationship('quizSubmission.quiz', 'title')
                    ->label('Filter by Quiz')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                Tables\Filters\SelectFilter::make('student')
                    ->relationship('quizSubmission.student.user', 'name')
                    ->label('Filter by Student')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                Tables\Filters\TernaryFilter::make('is_correct')
                    ->label('Answer Status')
                    ->placeholder('All Answers')
                    ->trueLabel('Correct Answers')
                    ->falseLabel('Incorrect Answers'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([])  // Remove bulk actions as responses shouldn't be modified
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
            'index' => Pages\ListQuizQuestionResponses::route('/'),
            //            'view' => Pages\ViewQuizQuestionResponse::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['quizSubmission.quiz', 'quizSubmission.student', 'quizQuestion', 'quizQuestionOption']);
    }
}
