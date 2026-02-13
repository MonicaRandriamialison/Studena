<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = [
        'owner_type',
        'owner_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    public function owner()
    {
        return $this->morphTo();
    }
}
