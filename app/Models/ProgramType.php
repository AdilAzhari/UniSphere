<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
    ];

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
