<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProctorResource\Pages;
use App\Models\Proctor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class ProctorResource extends Resource
{
    protected static ?string $model = Proctor::class;

    protected static ?string $navigationGroup = 'Enrollments & Student Progress';

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel = 'Proctors';

    protected static ?string $modelLabel = 'Proctor';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Proctor Information Section
                Forms\Components\Section::make('Proctor Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        PhoneInput::make('phone_number')
                            ->label('Phone Number')
                            ->placeholder('+1 (869) 863-5508')
                            ->useFullscreenPopup()
                            ->autoPlaceholder('aggressive')
                            ->defaultCountry('US'),

                    ])->columns(2),

                // Address Information Section
                Forms\Components\Section::make('Address Information')
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->label('Full Address')
                            ->placeholder('Enter full address')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('city')
                            ->label('City')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('state')
                            ->label('State')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('country')
                            ->label('Country')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),

                // Student Assignment Section
                Forms\Components\Section::make('Student Assignment')
                    ->schema([
                        Forms\Components\Select::make('student_id')
                            ->label('Assigned Student')
                            ->relationship('student.user', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Phone Number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('city')
                    ->label('City')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('state')
                    ->label('State')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('country')
                    ->label('Country')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('student.user.name')
                    ->label('Assigned Student')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add filters here if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->color('primary'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            // Add relations here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProctors::route('/'),
            'create' => Pages\CreateProctor::route('/create'),
            'edit' => Pages\EditProctor::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary'; // Customize the badge color
    }
}
