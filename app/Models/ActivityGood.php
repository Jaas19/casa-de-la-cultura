<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityGood extends Model
{
    protected $fillable = [
        'name',
        'activity_id',
        'good_id',
        'quantity_requested'
    ];
}
