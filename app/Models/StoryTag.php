<?php

namespace App\Models;

use Database\Factories\StoryTagFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StoryTag extends Model
{
    /** @use HasFactory<StoryTagFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug', 'count'];

    public function stories(): /**/ BelongsToMany
    {
        return $this->belongsToMany(Story::class);
    }
}
