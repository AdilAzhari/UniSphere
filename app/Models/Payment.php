<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'payment_date',
        'status',
        'method',
        'student_id',
        'course_id',
        'transaction_type',
    ];

    protected $attributes =
        [
            'transaction_type' => 'Exam/Course Processing Fee',
            'method' => 'Credit Card',
            'status' => 'pending',
        ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function scopeSearch($query, $search): void
    {
        $query->where(function ($query) use ($search): void {
            $query->Where('method', 'like', "%$search%")
                ->orWhere('amount', 'like', "%$search%")
                ->orWhere('status', 'like', "%$search%")
                ->orWhere('payment_date', 'like', "%$search%")
                ->orWhere('transaction_type', 'like', "%$search%")
                ->orWhereHas('course', function ($query) use ($search): void {
                    $query->where('name', 'like', "%$search%")
                        ->orWhere('code', 'like', "%$search%");
                });
        });
    }
}
