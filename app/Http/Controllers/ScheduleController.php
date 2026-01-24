<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Models\Discipline;
use App\Models\Lesson;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function create(Discipline $discipline){
        $this->authorize('update', $discipline);
        $lessons = $discipline->lessons()->where('status', 1)->orderBy('name')->get();
        return view('schedule.create', compact('discipline', 'lessons'));
    }

    public function store(Request $request, Discipline $discipline){
        $this->authorize('update', $discipline);
        $validatedData = $request->validate([
            'date' => 'required|date',
            'description' => 'nullable|max:255|string',
            'starting_time' => 'required|date_format:H:i',
            'ending_time' => 'required|date_format:H:i|after:starting_time',
            'lesson_id' => [
                'required', Rule::exists('lessons', 'id')->where(function ($query) use ($discipline) {
                return $query->where('discipline_id', $discipline->id);
                }),
            ]]
        );
        try{
            Schedule::create($validatedData);
            return redirect()->route('lesson.calendar', $discipline->id)->with('success', "Clase agendada exitosamente.");
        } catch(\Exception $e){
            Log::error("Error al agendar la clase: " . $e->getMessage());
            return back()->with('error', 'No se pudo agendar la clase, intente más tarde.')->withInput();
        }
    }

    public function delete(Request $request){

    }
}
