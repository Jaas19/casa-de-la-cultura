<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Period;
use App\Models\Lesson;

class PeriodController extends Controller
{
    public function index(Lesson $lesson){
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

    public function edit(Period $period){
        return view("period.edit", compact("lesson", "period"));
    }

    public function store(Request $request, Lesson $lesson){

        return redirect()->route("period.index", $lesson);
    }

    public function update(Request $request, Period $period){
        return redirect()->route("period.index", $period->lesson_id);
    }
}
