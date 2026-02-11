<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use App\Models\Discipline;
use App\Http\Controllers\Services\LessonServiceInterface;


class LessonController extends Controller
{
    protected $lessonService;
    public function __construct(LessonServiceInterface $lessonService) {
        $this->lessonService = $lessonService;
    }
    public function index(Discipline $discipline){
        $ids = Auth::user()->keys();
        if (!in_array($discipline->administrator_id, $ids)) {
            abort(403);
        }

        $periodsQuery = function($query) {
            $query->where('status', 1)
            ->orderBy('day', 'asc')
            ->orderBy('starting_time', 'asc');
        };

        $activeLessons = $discipline->lessons()->where("status", 1)->with(["periods" => $periodsQuery])->get();
        $inactiveLessons = $discipline->lessons()->where("status", 0)->with(["periods" => $periodsQuery])->get();
        return view('lesson.index', compact('activeLessons', 'inactiveLessons', 'discipline'));
    }

    public function calendar(Discipline $discipline){
        $ids = Auth::user()->keys();
        if (!in_array($discipline->administrator_id, $ids)) {
            abort(403);
        }
        $activeLessons = $discipline->lessons()->where("status", 1)->get();
        $inactiveLessons = $discipline->lessons()->where("status", 0)->get();
        return view('discipline.calendar', compact('activeLessons', 'inactiveLessons', 'discipline'));
    }

    public function generalCalendar() {
        $discipline = new Discipline();
        $discipline-> id = 0;
        $discipline->name = "Calendario general";

        $ids = Auth::user()->keys();

        $activeLessons = Lesson::whereHas('discipline', function($q) use ($ids) {
            $q->whereIn('administrator_id', $ids);
        })->where('status', 1)->get();
        $inactiveLessons = collect();

        return view('discipline.calendar', compact('activeLessons', 'inactiveLessons', 'discipline'));
    }

    public function create(Discipline $discipline){
        $ids = Auth::user()->keys();
        if (!in_array($discipline->administrator_id, $ids)) {
            abort(403);
        }
        return view('lesson.create', compact('discipline'));
    }

    public function store(Request $request, Discipline $discipline){
        $this->authorize('update', $discipline);
        $validatedData = $request->validate(
            [
                'name' => 'string|max:255|required',
                'description' => 'string|max:255|nullable',
                'color' => ['required', Rule::in(['blue', 'cyan', 'brown', 'green', 'lime', 'yellow', 'purple'])],
            ],
            [
                'name.string' => 'El nombre no es válido.',
                'name.max'  => 'El nombre es muy largo.',
                'name.required' => 'El nombre es obligatorio.',
                'description.string' => 'La descripción no es válida.',
                'description.max' => 'La descripción es muy larga.',
                'color.required' =>  'El color es obligatorio',
                'color.in' => 'El color no es válido',
            ]
        );

        try {
            $this->lessonService->storeLesson($validatedData, $discipline->id);
            return redirect()
            ->route('lesson.index', $discipline->id)
            ->with('success', 'Clase creada correctamente');

        } catch (\Exception $e) {
            Log::error("Error creando la clase: " . $e->getMessage());
            return back()
            ->with('error', 'Ocurrió un error al crear la clase, intente más tarde.')
            ->withInput();
        }

    }

    public function edit(Discipline $discipline, Lesson $lesson){
        $ids = Auth::user()->keys();
        if (!in_array($discipline->administrator_id, $ids)) {
            abort(403);
        }
        return view('lesson.edit', compact("discipline", "lesson"));
    }

    public function update(Request $request, Discipline $discipline, Lesson $lesson){
        $ids = Auth::user()->keys();
        if (!in_array($discipline->administrator_id, $ids)) {
            abort(403);
        }
        $validatedData = $request->validate(
            [
                'name' => 'string|max:255|required',
                'description' => 'string|max:255|nullable',
                'status' => 'int|max:1|required'
            ],
            [
                'name.string' => 'El nombre no es válido.',
                'name.max'  => 'El nombre es muy largo.',
                'name.required' => 'El nombre es obligatorio.',
                'description.string' => 'La descripción no es válida.',
                'description.max' => 'La descripción es muy larga.',
                'status.int' => 'Estado no válido',
                'status.max' => 'Estado muy largo',
                'status.required' => 'El estado es obligatorio'
            ]
        );
        try{
            $this->lessonService->updateLesson($lesson, $validatedData);
            return redirect()
            ->route('lesson.index', $discipline->id)
            ->with('success', 'Clase actualizada correctamente');
        } catch (\Exception $e) {
            Log::error("Error actualizado la clase $lesson->id:" . $e->getMessage());
            return back()
            ->with('error', 'Ocurrió un error al crear la clase, intente más tarde.')
            ->withInput();
        }
    }

    public function getCalendarLessons(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'discipline_id' => 'nullable',
        ]);

        $parameter = $validatedData['discipline_id'] ?: Auth::user()->keys();

        $data = $this->lessonService->getMonthlyLessons(
            $parameter,
            $validatedData['date']
        );

        return response()->json($data);
    }

}
