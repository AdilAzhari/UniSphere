<?php

namespace App\Filament\Admin\Resources;

use App\Enums\ProctorStatus;
use App\Filament\Admin\Resources\EnrollmentResource\Pages;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Term;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Enrollments & Student Progress';

    protected static ?string $modelLabel = 'Enrollment';

    protected static ?string $pluralModelLabel = 'Enrollments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Enrollment Details')
                    ->schema([
                        Forms\Components\Radio::make('enrollment_status')
                            ->options([
                                'enrolled' => 'Enrolled',
                                'pending' => 'Pending',
                                'completed' => 'Completed',
                                'dropped' => 'Dropped',
                            ])
                            ->required()
                            ->inline(),

                        Forms\Components\DatePicker::make('enrollment_date')
                            ->required()
                            ->native(false)
                            ->displayFormat('M d, Y'),

                        Forms\Components\DatePicker::make('completion_date')
                            ->required()
                            ->native(false)
                            ->displayFormat('M d, Y'),

                        Forms\Components\Select::make('student_id')
                            ->relationship('student.user', 'name')
                            ->options(Student::pluck('id', 'user_id'))
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('proctor_status')
                            ->options(ProctorStatus::class)
                            ->required()
                            ->native(false),

                        Forms\Components\Select::make('term_id')
                            ->relationship('term', 'id')
                            ->options(Term::pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Toggle::make('proctored')
                            ->label('Proctor Required')
                            ->required(),

                        Forms\Components\Select::make('course_id')
                            ->relationship('course', 'name')
                            ->options(Course::all()->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('enrollment_status')
                    ->label('Enrollment Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'enrolled' => 'warning',
                        'pending' => 'gray',
                        'completed' => 'success',
                        'dropped' => 'danger',
                        default => 'info',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('proctor_status')
                    ->label('Proctor Status')
                    ->badge()
                    ->color(fn (ProctorStatus $state): string => match ($state) {
                        ProctorStatus::PENDING => 'warning',
                        ProctorStatus::APPROVED => 'success',
                        ProctorStatus::REJECTED => 'danger',
                    })
                    ->formatStateUsing(fn (ProctorStatus $state): string => $state->value)
                    ->sortable(),

                Tables\Columns\TextColumn::make('enrollment_date')
                    ->label('Enrollment Date')
                    ->date('M d, Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('student.user.name')
                    ->label('Student Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('course.name')
                    ->label('Course')
                    ->sortable()
                    ->searchable(),

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
                Tables\Filters\SelectFilter::make('enrollment_status')
                    ->options([
                        'enrolled' => 'Enrolled',
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'dropped' => 'Dropped',
                    ])
                    ->label('Enrollment Status'),

                Tables\Filters\SelectFilter::make('proctor_status')
                    ->options(ProctorStatus::class)
                    ->label('Proctor Status'),
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
            ->defaultSort('enrollment_date', 'desc');
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
            'index' => Pages\ListEnrollments::route('/'),
            'create' => Pages\CreateEnrollment::route('/create'),
            'edit' => Pages\EditEnrollment::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::$model::query()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::$model::query()->count() > 10 ? 'primary' : 'success';
    }
}
