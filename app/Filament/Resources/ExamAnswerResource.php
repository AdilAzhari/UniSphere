<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ExamAnswerResource\Pages;
use App\Models\ExamAnswer;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;

class ExamAnswerResource extends Resource
{
    protected static ?string $model = ExamAnswer::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    protected static ?string $navigationGroup = 'Assessment & Grading';

    protected static ?string $navigationLabel = 'Exam Answers';

    protected static ?string $modelLabel = 'Exam Answer';

    protected static ?string $pluralModelLabel = 'Exam Answers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Answer Information')
                    ->schema([
                        Forms\Components\Select::make('Exam_question_id')
                            ->relationship('question', 'question_text')
                            ->required()
                            ->label('Exam Question')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Textarea::make('answer_text')
                            ->required()
                            ->label('Answer Text')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_correct')
                            ->required()
                            ->label('Is Correct?'),
                    ])
                    ->columns(),

                Section::make('Audit Information')
                    ->schema([
                        Forms\Components\Select::make('created_by')
                            ->relationship('createdBy', 'name')
                            ->default(auth()->id())
                            ->disabled()
                            ->dehydrated(), // تأكد من تمرير القيمة إلى الاستعلام
                        Forms\Components\Select::make('updated_by')
                            ->relationship('updatedBy', 'name')
                            ->default(auth()->id())
                            ->disabled()
                            ->dehydrated(), // تأكد من تمرير القيمة إلى الاستعلام
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
                Tables\Columns\TextColumn::make('question.id')
                    ->label('Exam Question')
                    ->searchable()
                    ->default(null)
                    ->limit(50),
                Tables\Columns\TextColumn::make('answer_text')
                    ->label('Answer Text')
                    ->searchable()
                    ->limit(50),
                BadgeColumn::make('is_correct')
                    ->label('Is Correct?')
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ])
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Correct' : 'Incorrect')
                    ->sortable(),
                Tables\Columns\TextColumn::make('createdBy.name')
                    ->label('Created By')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updatedBy.name')
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
                Tables\Filters\SelectFilter::make('exam_question_id')
                    ->relationship('question', 'question_text')
                    ->label('Exam Question'),
                Tables\Filters\SelectFilter::make('is_correct')
                    ->options([
                        true => 'Correct',
                        false => 'Incorrect',
                    ])
                    ->label('Is Correct?'),
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
            'index' => Pages\ListExamAnswers::route('/'),
            'create' => Pages\CreateExamAnswer::route('/create'),
            'edit' => Pages\EditExamAnswer::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::$model::query()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 0 ? 'primary' : 'gray';
    }
}
