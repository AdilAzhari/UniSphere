<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ExamResource\Pages;
use App\Filament\Admin\Resources\ExamResource\RelationManagers;
use App\Models\Exam;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ExamResource extends Resource
{
    protected static ?string $model = Exam::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Assessment & Grading';

    protected static ?string $navigationLabel = 'Exams';

    protected static ?string $modelLabel = 'Exam';

    protected static ?string $pluralModelLabel = 'Exams';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Exam Information')
                    ->schema([
                        Forms\Components\DatePicker::make('exam_date')
                            ->required()
                            ->label('Exam Date'),
                        Forms\Components\TextInput::make('exam_code')
                            ->required()
                            ->label('Exam Code')
                            ->unique(ignoreRecord: true),
                        Forms\Components\RichEditor::make('exam_description')
                            ->label('Exam Description')
                            ->placeholder('Enter the description of the exam')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('exam_rules')
                            ->label('Exam Rules')
                            ->placeholder('Enter the rules of the exam')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(),

                Section::make('Exam Details')
                    ->schema([
                        Forms\Components\Select::make('class_group_id')
                            ->relationship('classGroup', 'group_number')
                            ->required()
                            ->label('Class Group'),
                        Forms\Components\Select::make('exam_passing_score')
                            ->required()
                            ->default('60%')
                            ->options([
                                '50' => '50%',
                                '55' => '55%',
                                '60' => '60%',
                                '65' => '65%',
                                '70' => '70%',
                            ])
                            ->label('Passing Score'),
                        Forms\Components\Select::make('exam_duration')
                            ->required()
                            ->label('Exam Duration')
                            ->placeholder('Choice the duration of the exam')
                            ->options([
                                'one Hour' => '1/hr',
                                'one and half' => '1.5/hr',
                                'two Hour' => '2/hr',
                            ]),
                    ])
                    ->columns(),

                Section::make('Teacher & Course')
                    ->schema([
                        Forms\Components\Select::make('teacher_id')
                            ->label('Select The Teacher')
                            ->searchable()
                            ->options(function () {
                                return User::whereHas('teacher')
                                    ->get()
                                    ->pluck('name', 'id');
                            })
                            ->getSearchResultsUsing(function (string $search) {
                                return User::whereHas('teacher')
                                    ->where('name', 'like', "%$search%")
                                    ->limit(50)
                                    ->pluck('name', 'id');
                            })
                            ->getOptionLabelUsing(fn ($value): ?string => User::find($value)?->name)
                            ->afterStateUpdated(function ($state, callable $set): void {
                                $teacherId = Teacher::where('user_id', $state)->value('id');
                                $set('teacher_id', $teacherId);
                            }),
                        Forms\Components\Select::make('course_id')
                            ->label('Select The Course')
                            ->required()
                            ->relationship('course', 'name'),
                    ])
                    ->columns(),

                Section::make('Audit Information')
                    ->schema([
                        Forms\Components\Select::make('created_by')
                            ->relationship('createdBy', 'name')
                            ->default(function () {
                                if (Auth::check() && Auth::user()->created_by === null) {
                                    return Auth::id();
                                }
                            })
                            ->disabled(),
                        Forms\Components\Select::make('updated_by')
                            ->relationship('updatedBy', 'name')
                            ->default(Auth::id())
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
                Tables\Columns\TextColumn::make('exam_date')
                    ->label('Exam Date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('exam_code')
                    ->label('Exam Code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('exam_description')
                    ->label('Exam Description')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('exam_duration')
                    ->label('Exam Duration')
                    ->searchable(),
                Tables\Columns\TextColumn::make('exam_passing_score')
                    ->label('Passing Score')
                    ->searchable(),
                Tables\Columns\TextColumn::make('teacher.user.name')
                    ->label('Teacher')
                    ->sortable(),
                Tables\Columns\TextColumn::make('course.code')
                    ->label('Course Code')
                    ->numeric()
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
                Tables\Filters\SelectFilter::make('teacher_id')
                    ->relationship('teacher.user', 'name')
                    ->label('Teacher'),
                Tables\Filters\SelectFilter::make('course_id')
                    ->relationship('course', 'name')
                    ->label('Course'),
                Tables\Filters\Filter::make('exam_date')
                    ->form([
                        Forms\Components\DatePicker::make('exam_from')
                            ->label('Exam From'),
                        Forms\Components\DatePicker::make('exam_until')
                            ->label('Exam Until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['exam_from'],
                                fn ($query) => $query->whereDate('exam_date', '>=', $data['exam_from'])
                            )
                            ->when(
                                $data['exam_until'],
                                fn ($query) => $query->whereDate('exam_date', '<=', $data['exam_until'])
                            );
                    }),
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
            ->defaultSort('exam_date', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            'course' => RelationManagers\CourseRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExams::route('/'),
            'create' => Pages\CreateExam::route('/create'),
            'edit' => Pages\EditExam::route('/{record}/edit'),
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
