<?php

namespace App\Filament\Admin\Resources;

use App\Enums\StudentStatus;
use App\Filament\Admin\Resources\StudentResource\Pages;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Personal Information Section
                Forms\Components\Section::make('Personal Information')
                    ->description('Enter your personal information')
                    ->schema([
                        Forms\Components\TextInput::make('student_id')
                            ->disabled()
                            ->visible(fn ($livewire) => $livewire instanceof Pages\EditStudent),
                        Forms\Components\DatePicker::make('enrollment_date')
                            ->required(),
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required(),
                    ])
                    ->columns(3),

                // Academic Information Section
                Forms\Components\Section::make('Academic Information')
                    ->description('Enter your academic information')
                    ->schema([
                        Forms\Components\Select::make('term_id')
                            ->label('Term')
                            ->relationship('terms', 'name'),
                        Forms\Components\Select::make('program_id')
                            ->label('Program')
                            ->relationship('program', 'program_name'),
                        Forms\Components\Select::make('department_id')
                            ->label('Department')
                            ->relationship('department', 'name'),
                        Forms\Components\Select::make('status')
                            ->options(StudentStatus::class)
                            ->default(StudentStatus::ENROLLED->value),
                    ])
                    ->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student_id')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('enrollment_date')
                    ->date()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.code')
                    ->label('Department')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add filters here if needed
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
            // Uncomment and add relation managers as needed
            // AssignmentSubmissionsRelationManager::class,
            // CoursesRelationManager::class,
            // CurrentTermRelationManager::class,
            // DepartmentRelationManager::class,
            // EnrollmentsRelationManager::class,
            // ExamResultsRelationManager::class,
            // ProgramRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    /**
     * Display a navigation badge with the count of students.
     */
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
