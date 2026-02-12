<?php

namespace App\Http\Controllers\Services;

use App\Models\Lesson;
use App\Models\Schedule;
use App\Models\Period;
use App\Models\AuditLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Exception;

class LessonService implements LessonServiceInterface {
    public function storeLesson($data, $disciplineId){
        return DB::transaction(function () use ($data, $disciplineId) {
            $lesson = Lesson::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'discipline_id' => $disciplineId,
                'color' => $data['color'],
            ]);

            $lesson->load('discipline');

            if ($lesson->discipline->administrator_id != Auth::id()) {
                AuditLog::create([
                    "giver_id" => $lesson->discipline->administrator_id,
                    "collaborator_id" => Auth::id(),
                    "model_changed" => "Clase: $lesson->name ($lesson->discipline->name)",
                    "type" => "Creación"
                ]);
            }

            return $lesson;
        });
    }

    public function updateLesson($lesson, $data){
        return DB::transaction(function () use ($lesson, $data) {
            $oldLesson = $lesson->replicate();
            $oldName = $oldLesson->name;
            $lesson->load('discipline');

            if (!$lesson->update($data)) {
                throw new Exception("No se pudo actualizar la clase.");
            }

            if ($lesson->discipline->administrator_id != Auth::id()) {
                AuditLog::create([
                    "giver_id" => $lesson->discipline->administrator_id,
                    "collaborator_id" => Auth::id(),
                    "model_changed" => "Clase: $oldName ($lesson->discipline->name)",
                    "type" => "Actualización"
                ]);
            }

            return $lesson->fresh();
        });
    }


    public function getMonthlyLessons($disciplineId, ?string $dateInput) {
        $date = $dateInput ? Carbon::parse($dateInput) : Carbon::now();
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        $schedules = Schedule::query()
            ->when($disciplineId, function($query) use ($disciplineId) {
                return $query->whereHas('lesson', function ($q) use ($disciplineId) {
                    if (is_array($disciplineId)) {
                        $q->whereHas('discipline', function($dq) use ($disciplineId) {
                            $dq->whereIn('administrator_id', $disciplineId);
                        });
                    } else {
                        $q->where('discipline_id', $disciplineId);
                    }
                });
            })
            ->with('lesson.discipline')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->orderBy('starting_time')
            ->get();

        $activities = $this->formatSchedules($schedules);

        $periods = Period::query()
        ->with('lesson.discipline')
        ->when($disciplineId, function($query) use ($disciplineId) {
            return $query->whereHas('lesson', function ($q) use ($disciplineId) {
                if (is_array($disciplineId)) {
                    $q->whereHas('discipline', function($dq) use ($disciplineId) {
                        $dq->whereIn('administrator_id', $disciplineId);
                    });
                } else {
                    $q->where('discipline_id', $disciplineId);
                }
            });
        })
        ->where('status', 1)
        ->orderBy('day', 'asc')
        ->orderBy('starting_time', 'asc')
        ->get();

        $periods = $periods->map(function($period) {
            return [
                'id' => $period->id,
                'day' => $period->day,
                'status' => $period->status,
                'starting_time' => $period->starting_time ? $period->starting_time->format('g:i a') : null,
                'ending_time' => $period->ending_time ? $period->ending_time->format('g:i a') : null,
                'lesson_id' => $period->lesson_id,
                'lesson' => $period->lesson,
                'color' => $period->lesson->color ?? 'purple',
            ];
        });


        Carbon::setLocale('es');

        return [
            'month' => ucfirst($date->translatedFormat('F')),
            'year' => $date->year,
            'activities' => $activities,
            'periods' => $periods,
        ];
    }

    private function formatSchedules(Collection $schedules): Collection
    {
        return $schedules->groupBy(function ($schedule) {
            return (int) Carbon::parse($schedule->date)->format('d');
        })->map(function ($daySchedules) {
            return $daySchedules->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'name' => $schedule->lesson->name . " (" . $schedule->lesson->discipline->name . ")",
                    'status' => $schedule->status,
                    'starting_time' => Carbon::parse($schedule->starting_time)->format('H:i'),
                    'ending_time' => Carbon::parse($schedule->ending_time)->format('H:i'),
                    'color' => $schedule->lesson->color,
                    'time_array' => false,
                    'hours' => []
                ];
            });
        });
    }
}
