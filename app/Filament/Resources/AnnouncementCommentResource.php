<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AnnouncementCommentResource\Pages;
use App\Filament\Admin\Resources\AnnouncementCommentResource\RelationManagers;
use App\Models\AnnouncementComment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AnnouncementCommentResource extends Resource
{
    protected static ?string $model = AnnouncementComment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center';

    protected static ?string $navigationGroup = 'Announcement Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('comment')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('announcement_id')
                    ->label('Announcement')
                    ->relationship('announcement', 'message')
                    ->required(),
                Forms\Components\Select::make('parent_id')
                    ->label('Parent Comment')
                    ->relationship('parent', 'comment')
                    ->default(null),
                Forms\Components\Select::make('commented_by')
                    ->label('Commented By')
                    ->relationship('commentedBy', 'name')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('announcement.message')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('parent_id')
                    ->numeric()
                    ->default('N/A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('commentedBy.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('comment'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'replies' => RelationManagers\RepliesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnnouncementComments::route('/'),
            'create' => Pages\CreateAnnouncementComment::route('/create'),
            'edit' => Pages\EditAnnouncementComment::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
