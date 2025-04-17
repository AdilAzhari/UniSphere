<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\QuizSubmissionResource\Pages;
use App\Models\QuizSubmission;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuizSubmissionResource extends Resource
{
    protected static ?string $model = QuizSubmission::class;

    protected static ?string $activeNavigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Quiz Management';

    protected static ?string $navigationLabel = 'Quiz Submissions';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Quiz Details')
                    ->schema([
                        Forms\Components\Select::make('quiz_id')
                            ->relationship('quiz', 'title')
                            ->required()
                            ->label('Quiz Title')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('student_id')
                            ->required()
                            ->relationship('student.user', 'name')
                            ->label('Student Name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('score')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->label('Score')
                            ->minValue(0)
                            ->maxValue(100),
                    ])
                    ->columns(),

                Section::make('Submission Details')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'Pending' => 'Pending',
                                'Submitted' => 'Submitted',
                                'Graded' => 'Graded',
                            ])
                            ->required()
                            ->label('Status')
                            ->default('Pending'),
                        Forms\Components\DateTimePicker::make('submitted_at')
                            ->label('Submitted At')
                            ->default(now()),
                        Forms\Components\DateTimePicker::make('graded_at')
                            ->label('Graded At')
                            ->default(now()),
                        Forms\Components\Select::make('graded_by')
                            ->relationship('gradedBy', 'name')
                            ->label('Graded By')
                            ->default(auth()->user()->id)
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(),

                Section::make('Feedback & Remarks')
                    ->schema([
                        Forms\Components\Textarea::make('feedback')
                            ->label('Feedback')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('remarks')
                            ->label('Remarks')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('quiz.title')
                    ->label('Quiz Title')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('student.user.name')
                    ->label('Student Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('score')
                    ->label('Score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'Pending',
                        'success' => 'Submitted',
                        'primary' => 'Graded',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Submitted At')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('graded_at')
                    ->label('Graded At')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gradedBy.name')
                    ->label('Graded By')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Submitted' => 'Submitted',
                        'Graded' => 'Graded',
                    ])
                    ->label('Status'),
                Tables\Filters\Filter::make('submitted_at')
                    ->form([
                        Forms\Components\DatePicker::make('submitted_from')
                            ->label('Submitted From'),
                        Forms\Components\DatePicker::make('submitted_until')
                            ->label('Submitted Until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['submitted_from'],
                                fn ($query) => $query->whereDate('submitted_at', '>=', $data['submitted_from'])
                            )
                            ->when(
                                $data['submitted_until'],
                                fn ($query) => $query->whereDate('submitted_at', '<=', $data['submitted_until'])
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('submitted_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizSubmissions::route('/'),
            'create' => Pages\CreateQuizSubmission::route('/create'),
            'edit' => Pages\EditQuizSubmission::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::$model::query()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::$model::query()->count() > 0 ? 'primary' : 'gray';
    }
}
