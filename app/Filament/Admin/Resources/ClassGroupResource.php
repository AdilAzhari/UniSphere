<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ClassGroupResource\Pages;
use App\Models\ClassGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClassGroupResource extends Resource
{
    protected static ?string $model = ClassGroup::class;

    protected static ?string $navigationGroup = 'School Management';

    protected static ?string $navigationLabel = 'Class Groups';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static bool $hidden = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('group_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('semester')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('schedule')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('year')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('max_students')
                    ->required()
                    ->numeric()
                    ->default(30),
                Forms\Components\TextInput::make('current_students')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Select::make('course_id')
                    ->relationship('course', 'name')
                    ->required(),
                Forms\Components\Select::make('teacher_id')
                    ->relationship('teacher.user', 'name')
                    ->required(),
                Forms\Components\Select::make('term_id')
                    ->relationship('term', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group_number')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('semester')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('schedule')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_students')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('current_students')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('teacher.user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('term.name')
                    ->numeric()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassGroups::route('/'),
            'create' => Pages\CreateClassGroup::route('/create'),
            'edit' => Pages\EditClassGroup::route('/{record}/edit'),
        ];
    }
}
