<?php

namespace App\Models;

use App\Enums\TechnicalTeamRole;
use App\Enums\TechnicalTeamStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TechnicalTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
        'user_id',
        'status',
    ];

    protected $casts = [
        'status' => TechnicalTeamStatus::class,
        'role' => TechnicalTeamRole::class,
    ];

    protected $attributes = [
        'status' => TechnicalTeamStatus::ACTIVE,
        'role' => TechnicalTeamRole::ADMIN,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
