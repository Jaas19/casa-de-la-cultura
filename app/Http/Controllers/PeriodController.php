<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Period;
use App\Models\Lesson;

class PeriodController extends Controller
{
    public function index(Lesson $lesson){
        $ids = Auth::user()->keys();
        if (!in_array($lesson->discipline->administrator_id, $ids)) {
            abort(403);
        }

        $activePeriods = $lesson->periods()
        ->orderBy('day', 'asc')
        ->orderBy("starting_time", 'asc')
        ->where("status", 1)
        ->get();

        $inactivePeriods = $lesson->periods()
        ->orderBy('day', 'asc')
        ->orderBy("starting_time", 'asc')
        ->where("status", 0)
        ->get();
        return view("period.index", compact("lesson", "activePeriods", "inactivePeriods"));
    }

    public function create(Lesson $lesson){
        return view("period.create", compact("lesson"));
    }

    public function edit(Lesson $lesson, Period $period){
        $ids = Auth::user()->keys();
        if (!in_array($lesson->discipline->administrator_id, $ids)) {
            abort(403);
        }

        return view("period.edit", compact("lesson", "period"));
    }

    public function store(Request $request, Lesson $lesson){
        $ids = Auth::user()->keys();
        if (!in_array($lesson->discipline->administrator_id, $ids)) {
            abort(403);
        }
        $validatedData = $request->validate([
            "day" => "required|integer|between:1,7",
            "starting_time" => "required|date_format:H:i",
            "ending_time" => "required|date_format:H:i|after:starting_time",
            "status" => "required|in:1,0",
        ]);
        $lesson->periods()->create($validatedData);
        return redirect()->route("period.index", $lesson);
    }

    public function update(Request $request, Lesson $lesson, Period $period){
        $ids = Auth::user()->keys();
        if (!in_array($lesson->discipline->administrator_id, $ids)) {
            abort(403);
        }
        $validatedData = $request->validate([
            "day" => "required|integer|between:1,7",
            "starting_time" => "required|date_format:H:i",
            "ending_time" => "required|date_format:H:i|after:starting_time",
            "status" => "required|in:1,0",
        ]);
        try {
            $period->update($validatedData);
            return redirect()->route("period.index", $lesson)->with("success", "Período registrado con éxito.");
        } catch(\Exception $e){
            return back()->withInput()->with("error", "Hubo un error al registrar el período.");
        }

    }
}
