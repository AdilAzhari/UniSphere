<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TeacherResource\Pages;
use App\Filament\Admin\Resources\TeacherResource\RelationManagers;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Teacher Professional Information')
                    ->description('Enter professional and employment details')
                    ->schema([
                        Forms\Components\TextInput::make('qualification')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('experience')
                            ->required()
                            ->numeric()
                            ->integer(),
                        Forms\Components\TextInput::make('specialization')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('program_id')
                            ->relationship('program', 'program_name')
                            ->required(),
                        Forms\Components\Select::make('department_id')
                            ->relationship('department', 'name')
                            ->required(),
                        Forms\Components\TextInput::make('designation')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('hire_date')
                            ->required(),
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Teacher Name')
                            ->required(),

                    ])->columns(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Teacher Name'),
                Tables\Columns\TextColumn::make('department.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('hire_date')
                    ->date()
                    ->searchable()
                    ->sortable(),
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
            'courses' => RelationManagers\CoursesRelationManager::class,
            'exams' => RelationManagers\ExamsRelationManager::class,
            'gradedAssignments' => RelationManagers\GradedAssignmentsRelationManager::class,
            'user' => RelationManagers\UserRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
