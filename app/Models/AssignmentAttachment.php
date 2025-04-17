<?php

namespace App\Models;

use Database\Factories\AssignmentAttachmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentAttachment extends Model
{
    /** @use HasFactory<AssignmentAttachmentFactory> */
    use HasFactory;

    protected $fillable = [
        'file_path',
        'assignment_id',
    ];

    /**
     * Define a BelongsTo relationship between AssignmentAttachment and Assignment.
     */
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }
}
