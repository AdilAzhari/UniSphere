<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorldCitiesLocale extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'world_cities_locale';

    public $timestamps = false;
}
