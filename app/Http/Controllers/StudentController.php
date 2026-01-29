<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Discipline;
use App\Models\Person;

class StudentController extends Controller
{
    public function index(Discipline $discipline){
        $students = Student::where("discipline_id", $discipline->id)
        ->get();
        return view("student.index", compact("discipline", "students"));
    }
    public function create(Discipline $discipline){
        $persons = Person::where("status", "active")
        ->get();
        $disciplines = Discipline::where("administrator_id", Auth::id())->get();
        return view("student.create", compact("discipline", "persons", "disciplines"));
    }
    public function edit(Discipline $discipline, Student $student){
        $persons = Person::where("status", "active")
        ->get();
        $disciplines = Discipline::where("administrator_id", Auth::id())->get();
        return view("student.edit", compact("student", "persons", "disciplines", "discipline"));
    }
    public function store(Request $request, Discipline $discipline){
        $validatedData = $request->validate([
            "person_id" => 'required|integer|exists:people,id',
            "discipline_id" => 'required|integer|exists:disciplines,id',
            "next_payment" => 'required|date',
        ]);
        try {
            Student::create($validatedData);
            return redirect()->route("student.index", $discipline)->with("success", "Estudiante creado correctamente.");
        } catch(\Exception $e){
            return back()->withInput()->with("error", "Hubo un error, inténtelo de nuevo más tarde.");
        }
    }
    public function update(Request $request, Discipline $discipline, Student $student){
        $validatedData = $request->validate([
            "person_id" => 'required|integer|exists:people,id',
            "discipline_id" => 'required|integer|exists:disciplines,id',
            "status" => 'nullable|in:active,inactive',
            "next_payment" => 'required|date',
        ]);
        try{
            $student->update($validatedData);
            return redirect()->route("student.index", $discipline)->with("success", "Estudiante actualizado correctamente.");
        } catch(\Exception $e){
            return back()->withInput()->with("error", "Hubo un error, inténtelo de nuevo más tarde.");
        }
    }
    public function toggleStatus(Request $request, Discipline $discipline, Student $student){
        $validatedData = $request->validate([
            "status" => 'nullable|in:active,inactive',
        ]);
        try{
            $student->update($validatedData);
            return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente.',
            'data'    => [
                'id' => $student->id,
                'status' => $student->status]], 200);

        } catch(\Exception $e) {
            return response()->json([
            'success' => false,
            'message' => 'Error al cambiar el estado.',
            'error'   => $e->getMessage()], 500);
        }
    }
    public function registerPayment(Request $request, Discipline $discipline, Student $student){
        $validatedData = $request->validate([
            "next_payment" => 'required|string|in:Day,Week,Month',
        ]);
        $date = $this->interpretDate($validatedData['next_payment']);
        try {
            $student->update([
                "next_payment" => $date->toDateString()
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Fecha de pago actualizada.',
                'data'    => [
                    'id' => $student->id,
                    'next_payment' => $student->next_payment->format("d/m/Y")]], 200);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el pago.',
            ], 500);
        }
    }
    protected function interpretDate($date){
        $cleanDate = strtolower(trim($date));
        $now = now();
        switch($cleanDate){
            case("day"):
                return $now->tomorrow();
            case("week"):
                return $now->addWeek();
            case("month"):
                return $now->addMonth();
            default:
                return $now;
        }
    }
}
