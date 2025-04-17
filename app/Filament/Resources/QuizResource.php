<?php

namespace App\Filament\Admin\Resources;

use App\Enums\QuizDuration;
use App\Enums\QuizStatus;
use App\Enums\QuizType;
use App\Filament\Admin\Resources\AssignmentResource\RelationManagers\WeekRelationManager;
use App\Filament\Admin\Resources\ExamResource\RelationManagers\CourseRelationManager;
use App\Filament\Admin\Resources\QuizResource\Pages;
use App\Filament\Admin\Resources\QuizResource\RelationManagers\SubmissionsRelationManager;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $activeNavigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $navigationGroup = 'Quiz Management';

    protected static ?string $navigationParentItem = 'Notifications';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('course_id')
                    ->relationship('course', 'name')
                    ->required(),
                Forms\Components\Select::make('teacher_id')
                    ->relationship('teacher.user', 'name')
                    ->required(),
                Forms\Components\Select::make('class_group_id')
                    ->relationship('classGroup', 'group_number')
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\MarkdownEditor::make('description')
                    ->required()
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('type')
                    ->enum(QuizType::class)
                    ->options(QuizType::class)
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\MarkdownEditor::make('instructions')
                    ->required()
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('duration')
                    ->options(QuizDuration::class)
                    ->required(),
                Forms\Components\Radio::make('status')
                    ->options(QuizStatus::class)
                    ->enum(QuizStatus::class)
                    ->default('published')
                    ->inlineLabel(),
                Forms\Components\DateTimePicker::make('start_date')
                    ->required(),
                Forms\Components\DateTimePicker::make('end_date')
                    ->rules(['after:start_date'])
                    ->required(),
                Forms\Components\TextInput::make('passing_score')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('week_id')
                    ->relationship('week', 'title')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('course.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('duration'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('week.title')
                    ->numeric()
                    ->sortable(),
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
            CourseRelationManager::class,
            WeekRelationManager::class,
            //            QuestionsRelationManager::class,
            SubmissionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
