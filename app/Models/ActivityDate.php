<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActivityDate extends Model
{
    protected $fillable = [
        'name',
        'activity_id',
        'date'
    ];

    public function activity(): BelongsTo {
        return $this->belongsTo(Activity::class);
    }

    public function hours(): HasMany {
        return $this->hasMany(ActivityHour::class, 'date_id');
    }
}
