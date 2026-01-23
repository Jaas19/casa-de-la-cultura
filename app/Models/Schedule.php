<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;

class Schedule extends Model
{
    protected $fillable = [
        'lesson_id',
        'date',
        'starting_time',
        'ending_time',
        'description'
    ];

    public function lesson(){
        return $this->belongsTo(Lesson::class);
    }
}
