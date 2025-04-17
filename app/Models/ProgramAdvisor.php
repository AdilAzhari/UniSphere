<?php

namespace App\Models;

use Database\Factories\ProgramAdvisorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramAdvisor extends Model
{
    /** @use HasFactory<ProgramAdvisorFactory> */
    use HasFactory;

    protected $fillable = [
        'status',
        'department_id',
        'max_students',
        'name',
        'email',
    ];

    protected $casts = [
        'status' => 'boolean',
        'max_students' => 'integer',
        'name' => 'string',
        'email' => 'string',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /*
    * belongsTo
    */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
