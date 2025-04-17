<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'type',
        'content_type',
        'title',
        'description',
        'file',
        'thumbnail',
        'size',
        'path',
        'url',
        'filename',
        'extension',
        'status',
        'original_filename',
        'disk',
        'title',
        'description',
        'created_by',
        'updated_by',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'updated_by');
    }

    public function week(): BelongsTo
    {
        return $this->belongsTo(Week::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($announcement): void {
            $announcement->created_by = auth()->id(); // Set created_by to the current authenticated user's ID
            $announcement->updated_by = auth()->id(); // Set updated_by to the current authenticated user's ID
        });
        static::updating(function ($announcement): void {
            $announcement->updated_by = auth()->id();
        });
    }
}
