<?php

namespace App\Filament\Admin\Resources;

use App\Enums\AttendanceReason;
use App\Filament\Admin\Resources\AttendanceResource\Pages;
use App\Models\Attendance;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Attendance Management';

    protected static ?string $navigationLabel = 'Attendance Records';

    protected static ?string $modelLabel = 'Attendance Record';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Attendance Details Section
                Forms\Components\Section::make('Attendance Details')
                    ->schema([
                        Forms\Components\DatePicker::make('date')
                            ->label('Date')
                            ->required()
                            ->native(false)
                            ->displayFormat('M d, Y')
                            ->closeOnDateSelection(),
                        Forms\Components\Radio::make('status')
                            ->label('Status')
                            ->options([
                                'present' => 'Present',
                                'absent' => 'Absent',
                            ])
                            ->required()
                            ->inline(),
                        Forms\Components\Select::make('reason')
                            ->label('Reason for Absence')
                            ->options([AttendanceReason::class])
                            ->default(AttendanceReason::SICK)
                            ->placeholder('Enter reason (if absent)'),
                        Forms\Components\Textarea::make('notes')
                            ->label('Notes')
                            ->placeholder('Additional notes (if any)')
                            ->columnSpanFull(),
                    ])->columns(),

                // Relationships Section
                Forms\Components\Section::make('Relationships')
                    ->schema([
                        Forms\Components\Select::make('enrollment_id')
                            ->label('Enrollment')
                            ->relationship('enrollment', 'id')
                            ->required(),
                        Forms\Components\Select::make('teacher_id')
                            ->label('Teacher')
                            ->relationship('teacher.user', 'name')
                            ->required(),
                        Forms\Components\Select::make('student_id')
                            ->label('Student')
                            ->relationship('student.user', 'name')
                            ->required(),
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
                Tables\Columns\TextColumn::make('teacher.user.name')
                    ->label('Teacher')
                    ->sortable(),
                Tables\Columns\TextColumn::make('student.user.name')
                    ->label('Student')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date('M d, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'present' => 'success',
                        'absent' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('reason')
                    ->label('Reason'),
                Tables\Columns\TextColumn::make('enrollment.id')
                    ->label('Enrollment ID')
                    ->numeric()
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
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'present' => 'Present',
                        'absent' => 'Absent',
                    ])
                    ->label('Status'),
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('date_from')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('date_to')
                            ->label('To Date'),
                    ]),
                //                    ->query(function (Builder $query, array $data): Builder {
                //                        return $query
                //                            ->when(
                //                                $data['date_from'],
                //                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                //                            )
                //                            ->when(
                //                                $data['date_to'],
                //                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                //                            );
                //                    }),
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
            ->defaultSort('date', 'desc');
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::$model::query()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
}
