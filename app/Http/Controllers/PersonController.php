<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Services\PersonServiceInterface;
use App\Http\Controllers\Services\PositionServiceInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $positions = $this->positionService->listPositions();
        $userId = Auth::id();
        return view("person.index", compact("persons", "positions", "userId", "personsAssistance"));
    }

    public function create(){
        $positions = $this->positionService->listPositions();
        return view("person.create", compact("positions"));
    }

    public function update(Request $request){
        // $request->disciplineId;
        $disciplineId = $request->disciplineId ?? null;
        $userId = $request->userId;
        $positions = $this->positionService->listPositions();
        $person = $this -> personService -> findPerson($request->input("id"));
        return view("person.update", compact("positions", "person", "disciplineId"));
    }

    public function patch(Request $request) {
        $this->personService->updatePerson($request);
        return redirect(route("person.index"));
    }

    public function store(Request $request){
        $this->personService->createPerson($request);
        return redirect(route("person.create"));
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
