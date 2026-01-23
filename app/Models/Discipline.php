<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    protected $fillable = [
        'administrator_id',
        'name',
        'status'
    ];

    public function lessons()
    {
        return $this->hasMany(Lessons::class);
    }
}

