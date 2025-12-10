<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityPerson extends Model
{
    protected $fillable = [
        'name',
        'activity_id',
        'organizer_id'
    ];
}
