<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProgramResource\Pages;
use App\Models\Program;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Academic Structure';

    protected static ?string $navigationLabel = 'Programs';

    protected static ?string $modelLabel = 'Program';

    protected static ?string $pluralModelLabel = 'Programs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Program Information')
                    ->schema([
                        Forms\Components\TextInput::make('program_code')
                            ->required()
                            ->maxLength(255)
                            ->label('Program Code')
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('program_name')
                            ->required()
                            ->maxLength(255)
                            ->label('Program Name'),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->columnSpanFull()
                            ->label('Description'),
                        Forms\Components\TextInput::make('duration_years')
                            ->required()
                            ->numeric()
                            ->label('Duration (Years)')
                            ->minValue(1)
                            ->maxValue(10),
                    ])
                    ->columns(2),

                Section::make('Department & Status')
                    ->schema([
                        Forms\Components\Select::make('department_id')
                            ->required()
                            ->relationship('department', 'name')
                            ->label('Department')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('program_type_id')
                            ->relationship('programType', 'type')
                            ->required()
                            ->label('Program Type'),
                        Forms\Components\Select::make('program_status_id')
                            ->relationship('programStatus', 'status')
                            ->required()
                            ->label('Program Status'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('program_code')
                    ->label('Program Code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('program_name')
                    ->label('Program Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_years')
                    ->label('Duration (Years)')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->label('Department')
                    ->sortable()
                    ->searchable(),
                BadgeColumn::make('program_type')
                    ->label('Program Type')
                    ->colors([
                        'primary' => 'Undergraduate',
                        'success' => 'Postgraduate',
                        'warning' => 'Diploma',
                    ])
                    ->sortable(),
                BadgeColumn::make('program_status')
                    ->label('Program Status')
                    ->colors([
                        'success' => 'Graduated',
                        'primary' => 'Enrolled',
                        'warning' => 'Suspended',
                        'danger' => 'Expelled',
                    ])
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
                Tables\Filters\SelectFilter::make('program_type')
                    ->options([
                        'Undergraduate' => 'Undergraduate',
                        'Postgraduate' => 'Postgraduate',
                        'Diploma' => 'Diploma',
                    ])
                    ->label('Program Type'),
                Tables\Filters\SelectFilter::make('program_status')
                    ->options([
                        'Graduated' => 'Graduated',
                        'Enrolled' => 'Enrolled',
                        'Suspended' => 'Suspended',
                        'Expelled' => 'Expelled',
                    ])
                    ->label('Program Status'),
                Tables\Filters\SelectFilter::make('department_id')
                    ->relationship('department', 'name')
                    ->label('Department'),
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
            ->defaultSort('program_code', 'asc');
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
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 0 ? 'primary' : 'gray';
    }
}
