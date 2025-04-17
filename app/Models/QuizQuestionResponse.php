<?php

namespace App\Models;

use Database\Factories\QuizQuestionResponseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizQuestionResponse extends Model
{
    /** @use HasFactory<QuizQuestionResponseFactory> */
    use HasFactory;

    protected $fillable = [
        'quiz_submission_id',
        'quiz_question_id',
        'quiz_question_option_id',
        'is_correct',
    ];

    public static function create(array $array): QuizQuestionResponse
    {
        return QuizQuestionResponse::create($array);
    }

    public function quizSubmission(): BelongsTo
    {
        return $this->belongsTo(QuizSubmission::class);
    }

    public function quizQuestion(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class);
    }

    public function quizQuestionOption(): BelongsTo
    {
        return $this->belongsTo(QuizQuestionOption::class);
    }
}
