<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Lesson extends Model
{
    protected $fillable = [
        'discipline_id',
        'name',
        'description',
        'status',
        'color',
    ];

    public function discipline(){
        return $this->belongsTo(Discipline::class);
    }
    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
    public function periods(){
        return $this->hasMany(Period::class);
    }

}
