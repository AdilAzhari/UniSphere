<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ExamQuestionResource\Pages;
use App\Models\ExamQuestion;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;

class ExamQuestionResource extends Resource
{
    protected static ?string $model = ExamQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Assessment & Grading';

    protected static ?string $navigationLabel = 'Exam Questions';

    protected static ?string $modelLabel = 'Exam Question';

    protected static ?string $pluralModelLabel = 'Exam Questions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Question Information')
                    ->schema([
                        Forms\Components\Select::make('exam_id')
                            ->relationship('exam', 'exam_code')
                            ->required()
                            ->label('Exam Code')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Textarea::make('question_text')
                            ->required()
                            ->label('Question Text')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('type')
                            ->required()
                            ->label('Question Type')
                            ->options([
                                'multiple_choice' => 'Multiple Choice',
                                'true_false' => 'True/False',
                                'short_answer' => 'Short Answer',
                                'essay' => 'Essay',
                            ]),
                    ])
                    ->columns(),

                Section::make('Audit Information')
                    ->schema([
                        Forms\Components\Select::make('created_by')
                            ->relationship('createdBy.user', 'name')
                            ->default(auth()->id())
                            ->disabled(),
                        Forms\Components\Select::make('updated_by')
                            ->relationship('updatedBy.user', 'name')
                            ->default(auth()->id())
                            ->disabled(),
                    ])
                    ->columns(),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('exam.exam_code')
                    ->label('Exam Code')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('question_text')
                    ->label('Question Text')
                    ->searchable()
                    ->limit(50),
                BadgeColumn::make('type')
                    ->label('Question Type')
                    ->colors([
                        'primary' => 'multiple_choice',
                        'success' => 'true_false',
                        'warning' => 'short_answer',
                        'danger' => 'essay',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('createdBy.user.name')
                    ->label('Created By')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updatedBy.user.name')
                    ->label('Updated By')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('exam_id')
                    ->relationship('exam', 'exam_code')
                    ->label('Exam Code'),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'multiple_choice' => 'Multiple Choice',
                        'true_false' => 'True/False',
                        'short_answer' => 'Short Answer',
                        'essay' => 'Essay',
                    ])
                    ->label('Question Type'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListExamQuestions::route('/'),
            'create' => Pages\CreateExamQuestion::route('/create'),
            'edit' => Pages\EditExamQuestion::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::$model::query()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::$model::query()->count() > 0 ? 'primary' : 'gray';
    }
}
