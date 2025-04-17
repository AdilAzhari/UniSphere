<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MaterialResource\Pages;
use App\Models\Material;
use App\Models\Week;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $navigationGroup = 'Learning Resources';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section: Basic Information
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Material Title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('description')
                            ->label('Material Description')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Select::make('course_id')
                            ->label('Course')
                            ->required()
                            ->relationship('course', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Radio::make('type')
                            ->label('Material Type')
                            ->inline()
                            ->options([
                                'Video', 'PDF', 'ZIP', 'PPT', 'DOC', 'None',
                            ])
                            ->default('none')
                            ->required(),
                        Forms\Components\Radio::make('content_type')
                            ->label('Material Content Type')
                            ->inline()
                            ->options([
                                'lecture', 'assignment', 'resource', 'quiz', 'discussion', 'syllabus',
                            ])
                            ->default('lecture')
                            ->required(),
                        Forms\Components\Select::make('week_id')
                            ->label('Week')
                            ->relationship('week', 'week_number')
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->live()
                            ->options(function (callable $get) {
                                $courseId = $get('course_id'); // Get the currently selected course ID

                                return ! $courseId ? [] : Week::where('course_id', $courseId)
                                    ->pluck('week_number', 'id'); // Fetch week numbers for the course;
                            })
                            ->required(),
                    ]),

                // Section: Media/Files
                Forms\Components\Section::make('Media/Files')
                    ->schema([
                        Forms\Components\TextInput::make('thumbnail')
                            ->label('Thumbnail URL')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('size')
                            ->label('File Size (bytes)')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('path')
                            ->label('File Path')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('url')
                            ->label('File URL')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('filename')
                            ->label('Filename')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('original_filename')
                            ->label('Original Filename')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('disk')
                            ->label('Storage Disk')
                            ->maxLength(255),
                    ]),

                // Section: Audit Information
                Forms\Components\Section::make('Audit Information')
                    ->schema([
                        Forms\Components\Select::make('created_by')
                            ->label('Created By')
                            ->relationship('createdBy.user', 'name')
                            ->default(Auth::id())
                            ->required()
                            ->disabled(),
                        Forms\Components\Select::make('updated_by')
                            ->label('Updated By')
                            ->relationship('updatedBy.user', 'name')
                            ->default(Auth::id())
                            ->disabled(),
                    ])
                    ->columns(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Material Title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course.name')
                    ->label('Course')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('size')
                    ->label('Size (bytes)')
                    ->sortable(),
                Tables\Columns\TextColumn::make('createdBy.name')
                    ->label('Created By')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updatedBy.name')
                    ->label('Updated By')
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
                // Add filters if needed
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
            // Add relation managers if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'edit' => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::$model::query()->count();
    }
}
