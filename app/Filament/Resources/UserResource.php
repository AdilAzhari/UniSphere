<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers\StudentRelationManager;
use App\Filament\Admin\Resources\UserResource\RelationManagers\TeacherRelationManager;
use App\Filament\Admin\Resources\UserResource\RelationManagers\TechnicalTeamRelationManager;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->description('Enter basic user information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('First Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('middle_name')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('last_name')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('Preferred_name')
                            ->label('Preferred Name (Nickname) Optional')
                            ->maxLength(255)
                            ->default(null),
                    ])->columns(2),

                Forms\Components\Section::make('Contact Information')
                    ->description('Enter user contact details')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('Primary Email Address')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('secondary_email_address')
                            ->email()
                            ->maxLength(255)
                            ->default(null),
                        PhoneInput::make('phone_number')
                            ->label('Phone Number')
                            ->placeholder('+1 (869) 863-5508')
                            ->useFullscreenPopup()
                            ->autoPlaceholder('aggressive')
                            ->defaultCountry('US'),
                    ])->columns(2),

                Forms\Components\Section::make('Security')
                    ->description('Set user password')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required()
                            ->maxLength(255),
                    ])->columns(1),

                Forms\Components\Section::make('Personal Details')
                    ->description('Enter additional personal information')
                    ->schema([
                        Forms\Components\Select::make('gender')
                            ->options([
                                'male',
                                'female',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('date_of_birth')
                            ->firstDayOfWeek(1)
                            ->default(null),
                        Forms\Components\TextInput::make('nationality')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\Select::make('marital_status')
                            ->options([
                                'single',
                                'married',
                                'divorced',
                                'widowed',
                            ])->default('single'),
                    ])->columns(2),

                Forms\Components\Section::make('Address Information')
                    ->description('Enter user address details')
                    ->schema([
                        Forms\Components\TextInput::make('city_of_residence')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('state')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('zip_code')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('country_of_residence')
                            ->maxLength(255)
                            ->default(null),
                    ])->columns(2),

                Forms\Components\Section::make('Account Settings')
                    ->description('Configure user account settings')
                    ->schema([
                        Forms\Components\Select::make('role')
                            ->options([
                                'student',
                                'teacher',
                                'admin',
                                'technical_team',
                            ]),
                        Forms\Components\FileUpload::make('avatar')
                            ->label('Profile Picture')
                            ->image()
                            ->disk('public')
                            ->default(null),
                    ])->columns(2),

                Forms\Components\Section::make('System Information')
                    ->description('System-managed fields')
                    ->schema([
                        Forms\Components\Select::make('created_by')
                            ->label('Created By')
                            ->relationship('createdBy', 'name')
                            ->default(function () {
                                if (Auth::check() && Auth::user()->created_by === null) {
                                    return Auth::id();
                                }

                                return null;
                            })
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\Select::make('updated_by')
                            ->relationship('updatedBy', 'name')
                            ->default(function () {
                                if (Auth::check()) {
                                    return Auth::id();
                                }

                                return null;
                            })
                            ->disabled(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('First Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('nationality')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country_of_residence')
                    ->searchable(),
                Tables\Columns\TextColumn::make('marital_status'),
                Tables\Columns\IconColumn::make('is_admin')
                    ->boolean(),
                Tables\Columns\TextColumn::make('role'),
                Tables\Columns\TextColumn::make('created_by.id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_by.name')
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
            StudentRelationManager::class,
            TeacherRelationManager::class,
            TechnicalTeamRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
