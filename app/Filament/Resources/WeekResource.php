<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\WeekResource\Pages;
use App\Filament\Admin\Resources\WeekResource\RelationManagers;
use App\Models\Week;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WeekResource extends Resource
{
    protected static ?string $model = Week::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $navigationGroup = 'Academic Structure';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Week Information')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('week_number')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(10)
                                    ->placeholder('Enter week number (1-10)'),
                                Forms\Components\DatePicker::make('start_date')
                                    ->required(),
                                Forms\Components\DatePicker::make('end_date')
                                    ->required()
                                    ->afterOrEqual('start_date'),
                            ])
                            ->columns(),

                        Forms\Components\Section::make('Week Description')
                            ->schema([
                                Forms\Components\RichEditor::make('description')
                                    ->required()
                                    ->placeholder('Enter the description of the week')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Course Association')
                            ->schema([
                                Forms\Components\Select::make('course_id')
                                    ->required()
                                    ->relationship('course', 'name')
                                    ->searchable(),
                            ]),

                        Forms\Components\Section::make('Related Content')
                            ->schema([
                                Forms\Components\Select::make('term_id')
                                    ->relationship('term', 'name')
                                    ->searchable()
                                    ->placeholder('Select an assignment (optional)'),
                                //                                Forms\Components\Select::make('quiz_id')
                                //                                    ->relationship('quizzes', 'title')
                                //                                    ->searchable()
                                //                                    ->placeholder('Select a quiz (optional)'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('week_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('course.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assignment.title')
                    ->placeholder('No assignment')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quiz.title')
                    ->placeholder('No quiz')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('course')
                    ->relationship('course', 'name'),
                Tables\Filters\Filter::make('has_assignment')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('assignment_id')),
                Tables\Filters\Filter::make('has_quiz')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('quiz_id')),
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
            'course' => RelationManagers\CourseRelationManager::class,
            'assignments' => RelationManagers\AssignmentsRelationManager::class,
            'quizzes' => RelationManagers\QuizzesRelationManager::class,
            //            'announcements' => RelationManagers\AnnouncementsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWeeks::route('/'),
            'create' => Pages\CreateWeek::route('/create'),
            'edit' => Pages\EditWeek::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
