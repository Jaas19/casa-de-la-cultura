<?php

namespace App\Http\Controllers\Services;

use App\Models\Lesson;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class LessonService implements LessonServiceInterface {
    public function storeLesson($data, $disciplineId){
        return Lesson::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'discipline_id' => $disciplineId
        ]);
    }
    public function updateLesson($lesson, $data){
        if (!$lesson->update($data)) {
            throw new Exception("No se pudo actualizar la disciplina.");
        }
        return $lesson->fresh();
    }


    public function getMonthlyLessons(?int $disciplineId, ?string $dateInput) {
        $date = $dateInput ? Carbon::parse($dateInput) : Carbon::now();
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        $schedules = Schedule::query()
            ->when($disciplineId, function($query) use ($disciplineId) {
                return $query->whereHas('lesson', function ($q) use ($disciplineId) {
                    $q->where('discipline_id', $disciplineId);
                });
            })
            ->with('lesson.discipline')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->orderBy('starting_time')
            ->get();

        $activities = $this->formatSchedules($schedules);

        Carbon::setLocale('es');

        return [
            'month' => ucfirst($date->translatedFormat('F')),
            'year' => $date->year,
            'activities' => $activities,
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
