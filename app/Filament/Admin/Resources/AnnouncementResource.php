<?php

namespace App\Filament\Admin\Resources;

use App\Enums\AnnouncementType;
use App\Filament\Admin\Resources\AnnouncementResource\Pages;
use App\Models\Announcement;
use App\Models\ClassGroup;
use App\Models\Week;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center';

    protected static ?string $navigationGroup = 'Announcement Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // User Section
                Forms\Components\Section::make('User Information')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->required(),
                    ])->columns(1),

                // Course and Week Section
                Forms\Components\Section::make('Course & Week')
                    ->schema([
                        // Course Dropdown
                        Forms\Components\Select::make('course_id')
                            ->label('Course')
                            ->relationship('course', 'name')
                            ->required()
                            ->live() // Enable live updates
                            ->afterStateUpdated(function ($state, Forms\Set $set): void {
                                $set('week_id', null);
                                $set('class_group_id', null);
                            }),

                        // Week Dropdown (filtered by selected course)
                        Forms\Components\Select::make('week_id')
                            ->label('Week')
                            ->options(function (Forms\Get $get) {
                                // Get the selected course_id
                                $courseId = $get('course_id');

                                // If no course is selected, return an empty array
                                if (! $courseId) {
                                    return [];
                                }

                                // Fetch weeks for the selected course
                                return Week::where('course_id', $courseId)
                                    ->pluck('week_number', 'id');
                            })
                            ->required()
                            ->live(), // Enable live updates

                        // Class Group Dropdown (filtered by selected course)
                        Forms\Components\Select::make('class_group_id')
                            ->label('Class Group')
                            ->options(function (Forms\Get $get) {
                                // Get the selected course_id
                                $courseId = $get('course_id');

                                // If no course is selected, return an empty array
                                if (! $courseId) {
                                    return [];
                                }

                                // Fetch class groups for the selected course
                                return ClassGroup::where('course_id', $courseId)
                                    ->pluck('group_number', 'id');
                            })
                            ->default(1),
                    ])->columns(2),

                // Announcement Details Section
                Forms\Components\Section::make('Announcement Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('message')
                            ->label('Message')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(1),

                // Status and Type Section
                Forms\Components\Section::make('Status & Type')
                    ->schema([
                        Forms\Components\Radio::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ])
                            ->required(),
                        Forms\Components\Select::make('type')
                            ->label('Type')
                            ->options(AnnouncementType::class)
                            ->default(AnnouncementType::values()[0])
                            ->required(),
                    ])->columns(2),

                // Hidden created_by field (automatically populated)
                Forms\Components\Hidden::make('created_by')
                    ->default(auth()->id()), // Set created_by to the current authenticated user's ID
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable(),
                Tables\Columns\TextColumn::make('course.name')
                    ->label('Course')
                    ->sortable(),
                Tables\Columns\TextColumn::make('week.week_number')
                    ->label('Week')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Active' => 'success',
                        'Inactive' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Deleted At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            // Add relations here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
