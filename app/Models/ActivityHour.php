<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityHour extends Model
{
    protected $fillable = [
        'name',
        'date_id',
        'starting_time',
        'ending_time'
    ];

    public function date(): BelongsTo {
        return $this->belongsTo(ActivityDate::class);
    }
}
