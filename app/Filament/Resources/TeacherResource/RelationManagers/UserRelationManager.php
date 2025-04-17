<?php

namespace App\Filament\Admin\Resources\TeacherResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class UserRelationManager extends RelationManager
{
    protected static string $relationship = 'user';

    public function form(Form $form): Form
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
                    ])->columns(),

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
                        Forms\Components\TextInput::make('phone_number')
                            ->tel()
                            ->maxLength(255)
                            ->default(null),
                    ])->columns(),

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
                    ])->columns(),

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
                    ])->columns(),

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
                    ])->columns(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('First Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(), ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
