<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Discipline;
use App\Http\Controllers\Services\LessonServiceInterface;

class LessonController extends Controller
{
    protected $lessonService;
    public function __construct(LessonServiceInterface $lessonService) {
        $this->lessonService = $lessonService;
    }
    public function index(Discipline $discipline){
        $this->authorize('index', $discipline);
        $activeLessons = $discipline->lessons()->where("status", 1)->get();
        return view('lesson.index', compact('activeLessons', 'discipline'));
    }

    public function calendar(Discipline $discipline){
        $this->authorize('calendar', $discipline);
        $activeLessons = $discipline->lessons()->where("status", 1)->get();
        $inactiveLessons = $discipline->lessons()->where("status", 0)->get();
        return view('discipline.calendar', compact('activeLessons', 'inactiveLessons', 'discipline'));
    }

    public function create(Discipline $discipline){
        $this->authorize('show', $discipline);
        return view('lesson.create', compact('discipline'));
    }

    public function store(Request $request, $discipline){
        $this->authorize('update', $discipline);
        $validatedData = $request->validate(
            [
                'name' => 'string|max:255|required',
                'description' => 'string|max:255|nullable',
            ],
            [
                'name.string' => 'El nombre no es válido.',
                'name.max'  => 'El nombre es muy largo.',
                'name.required' => 'El nombre es obligatorio.',
                'description.string' => 'La descripción no es válida.',
                'description.max' => 'La descripción es muy larga.',
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

    public function update(){
        //
    }

    public function getCalendarLessons(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'discipline_id' => 'required|exists:disciplines,id',
        ]);

        $data = $this->lessonService->getMonthlyLessons(
            $validated['discipline_id'],
            $validated['date']
        );

        return response()->json($data);
    }

}
