<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AssignmentSubmissionResource\Pages;
use App\Models\AssignmentSubmission;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class AssignmentSubmissionResource extends Resource
{
    protected static ?string $model = AssignmentSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Assignments & Submissions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Assignment Section
                Forms\Components\Section::make('Assignment Information')
                    ->schema([
                        Forms\Components\Select::make('assignment_id')
                            ->label('Assignment')
                            ->relationship('assignment', 'title')
                            ->required(),
                    ])->columns(1),

                // Student Section
                Forms\Components\Section::make('Student Information')
                    ->schema([
                        Forms\Components\Select::make('student_id')
                            ->label('Student')
                            ->relationship('student.user', 'name')
//                            ->relationship('student', 'name')
                            ->required(),
                    ])->columns(1),

                // Submission Details Section
                Forms\Components\Section::make('Submission Details')
                    ->schema([
                        Forms\Components\TextInput::make('obtained_marks')
                            ->label('Obtained Marks')
                            ->numeric()
                            ->default(null),
                        Forms\Components\Radio::make('status')
                            ->label('Status')
                            ->options([
                                'submitted' => 'Submitted',
                                'graded' => 'Graded',
                                'late' => 'Late',
                                'pending' => 'Pending',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('remarks')
                            ->label('Remarks')
                            ->columnSpanFull(),
                        Forms\Components\DateTimePicker::make('submitted_at')
                            ->label('Submitted At'),
                        Forms\Components\DateTimePicker::make('graded_at')
                            ->label('Graded At'),
                        Forms\Components\TextInput::make('graded_by')
                            ->label('Graded By')
                            ->default(Auth::id())
                            ->disabled()
                            ->visible(fn ($livewire) => $livewire instanceof Pages\EditAssignmentSubmission),
                        Forms\Components\Textarea::make('feedback')
                            ->label('Feedback')
                            ->columnSpanFull(),
                    ])->columns(),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('assignment.title')
                    ->label('Assignment')
                    ->sortable(),
                Tables\Columns\TextColumn::make('student.user.name')
                    ->label('Student')
                    ->sortable(),
                Tables\Columns\TextColumn::make('obtained_marks')
                    ->label('Obtained Marks')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'submitted' => 'info',
                        'graded' => 'success',
                        'late' => 'warning',
                        'pending' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Submitted At')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('graded_at')
                    ->label('Graded At')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('graded_by')
                    ->label('Graded By')
                    ->numeric()
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
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'submitted' => 'Submitted',
                        'graded' => 'Graded',
                        'late' => 'Late',
                        'pending' => 'Pending',
                    ])
                    ->label('Status'),
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
            'index' => Pages\ListAssignmentSubmissions::route('/'),
            'create' => Pages\CreateAssignmentSubmission::route('/create'),
            'edit' => Pages\EditAssignmentSubmission::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
