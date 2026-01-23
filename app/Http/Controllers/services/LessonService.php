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
            'administrator_id' => $disciplineId
        ]);
    }


    public function getMonthlyLessons(int $disciplineId, ?string $dateInput) {
        $date = $dateInput ? Carbon::parse($dateInput) : Carbon::now();
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        $schedules = Schedule::query()
            ->whereHas('lesson', function ($query) use ($disciplineId) {
                $query->where('discipline_id', $disciplineId);
            })
            ->with('lesson')
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
                    'name' => $schedule->lesson->name,
                    'status' => $schedule->status,
                    'starting_time' => Carbon::parse($schedule->start_time)->format('H:i'),
                    'ending_time' => Carbon::parse($schedule->end_time)->format('H:i'),
                    'time_array' => false,
                    'hours' => []
                ];
            });
        });
    }
}
