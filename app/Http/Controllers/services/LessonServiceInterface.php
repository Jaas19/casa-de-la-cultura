<?php

namespace App\Http\Controllers\Services;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\InventoryAttribute;

interface LessonServiceInterface {
    public function getMonthlyLessons(int $disciplineId, ?string $dateInput);
}
