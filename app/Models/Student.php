<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    protected $fillable = [
        "person_id",
        "discipline_id",
        "next_payment",
        "status",
    ];

    public function discipline(){
        return $this->belongsTo(Discipline::class);
    }

    public function person(){
        return $this->belongsTo(Person::class);
    }

    protected $casts = [
        "next_payment" => "datetime",
    ];
}
