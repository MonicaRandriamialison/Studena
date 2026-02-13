<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    protected $fillable = ['full_name', 'bio', 'experience_years'];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function levels()
    {
        return $this->belongsToMany(Level::class);
    }

    public function availabilities()
    {
        return $this->morphMany(Availability::class, 'owner');
    }
}
