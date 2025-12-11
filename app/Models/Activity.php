<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Action;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'status',
        'starting_date',
        'ending_date',
        'starting_time',
        'ending_time',
        'important'
    ];

    public function dates(): HasMany {
        return $this->hasMany(ActivityDate::class);
    }
    public function goods(): HasMany {
        return $this->hasMany(ActivityGood::class);
    }
    public function organizers(): HasMany {
        return $this->hasMany(ActivityPerson::class);
    }
}
