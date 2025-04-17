<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AcademicProgressResource\Pages;
use App\Models\AcademicProgress;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AcademicProgressResource extends Resource
{
    protected static ?string $model = AcademicProgress::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Academic Management';

    protected static ?string $modelLabel = 'Student Progress';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        // Student Information Card
                        Forms\Components\Section::make('Student Information')
                            ->schema([
                                Forms\Components\Select::make('student_id')
                                    ->label('Student')
                                    ->relationship(
                                        'student.user',
                                        'name',
                                        fn (Builder $query) => $query->whereHas('student.user')
                                    )
//                                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->user->name)
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->columnSpanFull(),

                                Forms\Components\Select::make('program_id')
                                    ->label('Program')
                                    ->relationship('program', 'program_name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(1),

                        // Academic Status Card
                        Forms\Components\Section::make('Academic Status')
                            ->schema([
                                Forms\Components\Select::make('academic_standing')
                                    ->options([
                                        'good' => 'Good Standing',
                                        'warning' => 'Academic Warning',
                                        'probation' => 'Academic Probation',
                                        'suspension' => 'Academic Suspension',
                                    ])
                                    ->native(false)
                                    ->required(),

                                Forms\Components\Select::make('status')
                                    ->options([
                                        'On Track' => 'On Track',
                                        'At Risk' => 'At Risk',
                                        'Critical' => 'Critical',
                                    ])
                                    ->native(false)
                                    ->required(),
                            ])
                            ->columnSpan(1),
                    ]),

                Forms\Components\Section::make('Academic Performance')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\TextInput::make('gpa')
                                    ->label('Current GPA')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(4)
                                    ->step(0.01)
                                    ->required(),

                                Forms\Components\TextInput::make('cgpa')
                                    ->label('Cumulative GPA')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(4)
                                    ->step(0.01)
                                    ->required(),
                            ]),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\TextInput::make('total_credits')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),

                                Forms\Components\TextInput::make('progress_percentage')
                                    ->label('Program Progress')
                                    ->suffix('%')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->required(),
                            ]),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\TextInput::make('total_courses')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),

                                Forms\Components\TextInput::make('total_courses_completed')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),
                            ]),
                    ]),

                Forms\Components\Section::make('Course Statistics')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\TextInput::make('total_courses_failed')
                                    ->label('Failed Courses')
                                    ->helperText('Total number of failed courses')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),
                            ]),

                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\TextInput::make('total_courses_withdrawn')
                                    ->label('Withdrawn Courses')
                                    ->helperText('Total number of course withdrawals')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('student.user.name', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('student.user.name')
                    ->label('Student')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('program.program_name')
                    ->label('Program')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('gpa')
                    ->label('GPA')
                    ->sortable()
                    ->color(fn (string $state): string => match (true) {
                        $state >= 3.5 => 'success',
                        $state >= 2.0 => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\TextColumn::make('progress_percentage')
                    ->label('Progress')
                    ->suffix('%')
                    ->sortable()
                    ->color(fn (string $state): string => match (true) {
                        $state >= 75 => 'success',
                        $state >= 50 => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\TextColumn::make('academic_standing')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'good' => 'success',
                        'warning' => 'warning',
                        'probation', 'suspension' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'On Track' => 'success',
                        'At Risk' => 'warning',
                        'Critical' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('academic_standing')
                    ->options([
                        'good' => 'Good Standing',
                        'warning' => 'Academic Warning',
                        'probation' => 'Academic Probation',
                        'suspension' => 'Academic Suspension',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'On Track' => 'On Track',
                        'At Risk' => 'At Risk',
                        'Critical' => 'Critical',
                    ])
                    ->multiple(),

                Tables\Filters\Filter::make('low_gpa')
                    ->label('Low GPA')
                    ->query(fn (Builder $query): Builder => $query->where('gpa', '<', 2.0)),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcademicProgress::route('/'),
            'create' => Pages\CreateAcademicProgress::route('/create'),
            'edit' => Pages\EditAcademicProgress::route('/{record}/edit'),
        ];
    }
}
