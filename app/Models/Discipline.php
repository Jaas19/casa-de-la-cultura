<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;

class Discipline extends Model
{
    protected $fillable = [
        'administrator_id',
        'name',
        'status'
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}

