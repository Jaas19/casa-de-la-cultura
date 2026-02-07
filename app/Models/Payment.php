<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Payment extends Model
{
    protected $fillable = [
        "student_id",
        "discipline_id",
        "date",
        "method",
        "amount",
        "reference_number",
        "receipt_path",
    ];

    public function student(): BelongsTo {
        return $this->belongsTo(Student::class);
    }

    public function discipline(): BelongsTo {
        return $this->belongsTo(Discipline::class);
    }

    protected $casts = [
        'date' => 'date',
        'amount' => 'float',
    ];
}
