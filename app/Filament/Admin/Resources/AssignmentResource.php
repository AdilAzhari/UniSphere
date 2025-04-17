<?php

namespace App\Filament\Admin\Resources;

use App\Enums\AssignmentStatus;
use App\Filament\Admin\Resources\AssignmentResource\Pages;
use App\Models\Assignment;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $navigationGroup = 'Assignments & Submissions';

    public static function form(Form $form): Form
    {
        return $form->schema([
            static::getClassGroupSection(),
            static::getTeacherSection(),
            static::getCourseSection(),
            static::getAssignmentDetailsSection(),
            static::getStatusSection(),
            static::getSystemInformationSection(),
        ]);
    }

    private static function getClassGroupSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make('Class Information')
            ->schema([
                Forms\Components\Select::make('class_group_id')
                    ->label('Class Group')
                    ->relationship('classGroup', 'group_number')
                    ->required()
                    ->searchable(),
            ])
            ->columns(1);
    }

    private static function getTeacherSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make('Teacher Information')
            ->schema([
                Forms\Components\Select::make('teacher_id')
                    ->label('Teacher')
                    ->relationship('teacher.user', 'name')
                    ->required()
                    ->searchable(),
            ])
            ->columns(1);
    }

    private static function getCourseSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make('Course Information')
            ->schema([
                Forms\Components\Select::make('course_id')
                    ->label('Course')
                    ->relationship('course', 'name')
                    ->required()
                    ->searchable(),
            ])
            ->columns(1);
    }

    private static function getAssignmentDetailsSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make('Assignment Details')
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('description')
                    ->label('Description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('total_marks')
                    ->label('Total Marks')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100),
                Forms\Components\DateTimePicker::make('deadline')
                    ->label('Deadline')
                    ->required(),
                Forms\Components\FileUpload::make('file')
                    ->label('Attachment')
                    ->directory('assignments')
                    ->preserveFilenames()
                    ->downloadable()
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'image/*'])
                    ->maxSize(10240), // 10MB
            ])
            ->columns();
    }

    private static function getStatusSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make('Status')
            ->schema([
                Forms\Components\Radio::make('status')
                    ->label('Status')
                    ->options(AssignmentStatus::class)
                    ->default(AssignmentStatus::PENDING)
                    ->required()
                    ->inline(),
            ])
            ->columns(1);
    }

    private static function getSystemInformationSection(): Forms\Components\Section
    {
        return Forms\Components\Section::make('System Information')
            ->schema([
                Forms\Components\TextInput::make('created_by')
                    ->label('Created By')
                    ->default(Auth::id())
                    ->disabled()
                    ->visible(fn ($livewire) => $livewire instanceof Pages\EditAssignment),
                Forms\Components\TextInput::make('updated_by')
                    ->label('Updated By')
                    ->default(Auth::id())
                    ->disabled()
                    ->visible(fn ($livewire) => $livewire instanceof Pages\EditAssignment),
            ])
            ->columns()
            ->hidden(fn ($livewire) => ! $livewire instanceof Pages\EditAssignment);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('teacher.user.name')
                    ->label('Teacher')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('course.name')
                    ->label('Course')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => AssignmentStatus::COMPLETED,
                        'success' => AssignmentStatus::PENDING,
                        'danger' => AssignmentStatus::OVERDUE,
                    ]),
                Tables\Columns\TextColumn::make('deadline')
                    ->label('Deadline')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('status')
                    ->options(AssignmentStatus::class)
                    ->label('Status')
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssignments::route('/'),
            'create' => Pages\CreateAssignment::route('/create'),
            'edit' => Pages\EditAssignment::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::$model::query()->count();
    }
}
