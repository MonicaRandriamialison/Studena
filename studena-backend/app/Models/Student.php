<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['full_name', 'level'];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function availabilities()
    {
        return $this->morphMany(Availability::class, 'owner');
    }
}
