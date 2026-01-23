<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'discipline_id',
        'name',
        'description',
        'status'
    ];

    public function discipline(){
        return $this->belongsTo(Discipline::class);
    }
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
}
