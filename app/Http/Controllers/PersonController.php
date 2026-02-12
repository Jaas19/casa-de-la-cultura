<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Services\PersonServiceInterface;
use App\Http\Controllers\Services\PositionServiceInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\PositionType;
use App\Models\Position;
use App\Models\Person;


class PersonController extends Controller
{
    protected $personService;
    protected $positionService;
    public function __construct(PersonServiceInterface $personService, PositionServiceInterface $positionService) {
        $this->personService = $personService;
        $this->positionService = $positionService;
    }

    public function index(){
        $persons = $this->personService->listPersons();
        $personsAssistance = $this->personService->getControlledPersons(Auth::id());
        $positions = Position::with('type')->orderBy('position_type_id', 'asc') ->get();
        $positionTypes = PositionType::all();
        $userId = Auth::id();
        return view("person.index", compact("persons", "positions", "userId", "personsAssistance", "positionTypes"));
    }

    public function create(){
        $positions = $this->positionService->listPositions();
        return view("person.create", compact("positions"));
    }

    public function edit(Person $person){
        $userId = Auth::id();
        $positions = $this->positionService->listPositions();
        return view("person.update", compact("positions", "person"));
    }

    public function patch(Request $request) {
    try {
        $this->personService->updatePerson($request);
        return redirect()->route("person.index")->with('success', 'Persona actualizada correctamente.');
    } catch (\Exception $e) {
        Log::error("Error actualizando persona ID {$request->id}: " . $e->getMessage());
        return back()->withInput()->with('error', 'Error al actualizar los datos.');
    }
    }

    public function store(Request $request){
    try {
        $this->personService->createPerson($request);
        return redirect()->route("person.index")->with('success', 'Persona registrada exitosamente.');
    } catch (\Exception $e) {
        Log::error("Error registrando persona: " . $e->getMessage());
        return back()->withInput()->with('error', 'No se pudo completar el registro.');
    }
    }

    public function put(Request $request){
        return $this->personService->toggleStatus($request->input("id"));
    }
    public function put2(Request $request){
        return $this->personService->toggleAssistanceStatus($request->input("id"), Auth::id());
    }

    public function pdf(){
        return Pdf::loadView("pdfs.person.pdf", [
            'persons' => $this->personService->getControlledPersons(Auth::id())
        ])->stream();
    }

}
