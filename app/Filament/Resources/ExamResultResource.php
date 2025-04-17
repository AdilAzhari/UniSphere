<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ExamResultResource\Pages;
use App\Filament\Admin\Resources\ExamResultResource\RelationManagers;
use App\Models\ExamResult;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;

class ExamResultResource extends Resource
{
    protected static ?string $model = ExamResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Assessment & Grading';

    protected static ?string $navigationLabel = 'Exam Results';

    protected static ?string $modelLabel = 'Exam Result';

    protected static ?string $pluralModelLabel = 'Exam Results';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Exam Information')
                    ->schema([
                        Forms\Components\Select::make('exam_id')
                            ->label('Select The Exam')
                            ->required()
                            ->relationship('exam.classGroup', 'group_number')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('student_id')
                            ->label('Select The Student')
                            ->required()
                            ->relationship('student.user', 'name')
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2),

                Section::make('Result Details')
                    ->schema([
                        Forms\Components\TextInput::make('score')
                            ->required()
                            ->numeric()
                            ->label('Score')
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->required()
                            ->options([
                                'Passed', 'Failed', 'Absent',
                            ])
                            ->default('pass'),
                        Forms\Components\Textarea::make('notes')
                            ->label('Notes')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('exam.exam_code')
                    ->label('Exam Code')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('student.user.name')
                    ->label('Student Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('score')
                    ->label('Score')
                    ->numeric()
                    ->sortable(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'pass',
                        'danger' => 'fail',
                        'warning' => 'absent',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('notes')
                    ->label('Notes')
                    ->searchable()
                    ->limit(50),
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
                Tables\Filters\SelectFilter::make('student_id')
                    ->relationship('student.user', 'name')
                    ->label('Student Name'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pass' => 'Pass',
                        'fail' => 'Fail',
                        'absent' => 'Absent',
                    ])
                    ->label('Status'),
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
            'exam' => RelationManagers\ExamRelationManager::class,
            'student' => RelationManagers\StudentRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExamResults::route('/'),
            'create' => Pages\CreateExamResult::route('/create'),
            'edit' => Pages\EditExamResult::route('/{record}/edit'),
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
