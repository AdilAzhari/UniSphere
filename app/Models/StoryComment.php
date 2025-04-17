<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\StoryCommentFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoryComment extends Model
{
    /** @use HasFactory<StoryCommentFactory> */
    use HasFactory, SoftDeletes;

    // Specifies the attributes that can be mass assigned
    protected $fillable = ['content', 'story_id', 'student_id',
        'parent_id', 'status', 'published_at'];

    protected $attributes = [
        'status' => 'draft',
    ];

    /**
     * Get the Student that owns the StoryComment.
     * This defines a many-to-one relationship where a StoryComment belongs to a Student.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the Story that the StoryComment belongs to.
     * This defines a many-to-one relationship where a StoryComment belongs to a Story.
     */
    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

    /**
     * Get the replies (child comments) for the StoryComment.
     * This defines a one-to-many relationship where a StoryComment can have many replies (child comments).
     * The `parent_id` column is used to identify the parent comment.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(StoryComment::class, 'parent_id');
    }

    /**
     * Scope to filter published StoryComments.
     * This scope retrieves only StoryComments with the status 'published'.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Accessor and mutator for the `published_at` attribute.
     * The accessor formats the `published_at` timestamp for human-readable display.
     * The mutator ensures the `published_at` value is parsed as a Carbon instance.
     */
    protected function publishedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->diffForHumans(),
            set: fn ($value) => Carbon::parse($value),
        );
    }
}
