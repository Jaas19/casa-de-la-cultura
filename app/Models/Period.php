<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Period extends Model
{
    protected $fillable = [
        "lesson_id",
        "day",
        "starting_time",
        "ending_time",
    ];

    protected $casts = [
        "starting_time" => "datetime",
        "ending_time" => "datetime",
    ];


    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
