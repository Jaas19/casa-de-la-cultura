<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Services\DisciplineServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Discipline;
use Exception;

class DisciplineController extends Controller
{
    protected $disciplineService;

    public function __construct(DisciplineServiceInterface $disciplineService) {
        $this->disciplineService = $disciplineService;
    }

    public function index() {
        $activeDisciplines = Auth::user()->disciplines()->where("status", "1")->get();
        $inactiveDisciplines = Auth::user()->disciplines()->where("status", "0")->get();
        return view('discipline.index', compact('activeDisciplines', 'inactiveDisciplines'));
    }

    public function create() {
        return view('discipline.create');
    }

    public function store(Request $request) {
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255'
            ], [
                'name.required' => "El nombre es obligatorio.",
                'name.string' => "El nombre no es válido.",
                'name.max' => "El nombre es muy largo."
            ]
            );

        try {
            $this->disciplineService->storeDiscipline($validatedData, Auth::user());
            return redirect()
            ->route('discipline.index')
            ->with('success', 'Disciplina creada correctamente');

        } catch (\Exception $e) {
            Log::error("Error creando disciplina: " . $e->getMessage());
            return back()
            ->with('error', 'Ocurrió un error al crear la disciplina, intente más tarde.')
            ->withInput();
        }
    }

    public function edit(Discipline $discipline) {
        $this->authorize('update', $discipline);
        $disciplines = Auth::user()->disciplines()->where('id', "!=", $discipline->id)->get();
        return view('discipline.edit', compact('discipline', 'disciplines'));
}

    public function update(Request $request) {
        $validatedData = $request->validate(
            [
                'id' => 'required|exists:disciplines,id',
                'name' => 'required|string|max:255',
                'status' => 'nullable|integer'
            ], [
                'name.required' => "El nombre es obligatorio.",
                'name.string' => "El nombre no es válido.",
                'name.max' => "El nombre es muy largo.",
                'id.exists' => "La disciplina no existe."
            ]
            );
        $discipline = Discipline::findOrFail($request->id);
        $this->authorize('update', $discipline);

        try {
            $this->disciplineService->updateDiscipline($discipline, $validatedData);
            return redirect()->route("discipline.index")->with("success", "Disciplina actualizada correctamente");

        } catch (\Exception $e){
            Log::error("Error actualizando la disciplina {$discipline->id}: " . $e->getMessage());
            return back()->with("error", "Ocurrió un error inesperado al actualizar la disciplina");
        }
    }

    public function show(Discipline $discipline) {
        $this->authorize('show', $discipline);
        $activeLessons = $discipline->lessons->where('status', 1);
        $inactiveLessons = $discipline->lessons->where('status', 0);
        return view("discipline.show", compact("discipline", "activeLessons", "inactiveLessons"));
    }
}
