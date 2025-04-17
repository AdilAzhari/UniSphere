<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnnouncementComment extends Model
{
    use HasFactory;

    // Specifies the attributes that can be mass assigned
    protected $fillable = [
        'announcement_id',
        'user_id',
        'comment',
        'parent_id',
        'commented_by',
    ];

    /**
     * Define a relationship where a comment belongs to an announcement.
     * This establishes a link between the comment and its associated announcement.
     */
    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class);
    }

    /**
     * Define a relationship where a comment belongs to a user.
     * This represents the user who posted the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define a relationship where a comment may have a parent comment.
     * This is used for nested or threaded comments.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(AnnouncementComment::class, 'parent_id');
    }

    /**
     * Define a relationship where a comment is made by a specific user.
     * This keeps track of the user who authored the comment.
     */
    public function commentedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'commented_by');
    }

    /**
     * Define a relationship where a comment can have multiple child comments.
     * This allows for replies to be associated with a parent comment.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(AnnouncementComment::class, 'parent_id');
    }

    /**
     * Define a relationship where a comment can have multiple replies.
     * This is an alias for the comments() method to enhance readability.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(AnnouncementComment::class, 'parent_id');
    }
}
