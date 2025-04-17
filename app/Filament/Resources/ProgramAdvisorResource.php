<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProgramAdvisorResource\Pages;
use App\Models\ProgramAdvisor;
use Exception;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProgramAdvisorResource extends Resource
{
    protected static ?string $model = ProgramAdvisor::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Academic Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter the advisor\'s full name'),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->placeholder('Enter the advisor\'s email address'),

                Select::make('department_id')
                    ->relationship('department', 'name')
                    ->nullable()
                    ->placeholder('Select a department'),

                TextInput::make('max_students')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10)
                    ->nullable()
                    ->placeholder('Enter the maximum number of students'),

                Toggle::make('status')
                    ->default(false)
                    ->label('Active'),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Name'),

                TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->label('Email'),

                TextColumn::make('department.name')
                    ->sortable()
                    ->searchable()
                    ->label('Department'),

                TextColumn::make('max_students')
                    ->sortable()
                    ->label('Max Students'),

                IconColumn::make('status')
                    ->boolean()
                    ->label('Active')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
            ])
            ->filters([
                Tables\Filters\Filter::make('status')
                    ->label('Active Advisors')
                    ->query(fn ($query) => $query->where('status', true)),
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
            'index' => Pages\ListProgramAdvisors::route('/'),
            'create' => Pages\CreateProgramAdvisor::route('/create'),
            'edit' => Pages\EditProgramAdvisor::route('/{record}/edit'),
        ];
    }
}
