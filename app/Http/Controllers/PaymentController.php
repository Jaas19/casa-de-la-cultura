<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Services\paymentServiceInterface;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Discipline;

class PaymentController extends Controller
{
    public function index(Discipline $discipline) {
        $ids = Auth::user()->keys();
        if (!in_array($discipline->administrator_id, $ids)) {
            return back()->with("error", "Acceso denegado.");
        }
        $payments = Payment::with("student.person")->where("discipline_id", $discipline->id)->get();
        return view('payment.index', compact("payments", "discipline"));
    }

    public function create(Request $request, Discipline $discipline){
        $ids = Auth::user()->keys();
        if (!in_array($discipline->administrator_id, $ids)) {
            return back()->with("error", "Acceso denegado.");
        }

        $student = null;
        if ($request->has('student')) {
            $student = Student::with('person')
                ->where('id', $request->query('student'))
                ->where('discipline_id', $discipline->id)
                ->first();

        return view("payment.create", compact("discipline" , "student"));
        }
    }

    public function store(Request $request, Discipline $discipline){
        $ids = Auth::user()->keys();
        if (!in_array($discipline->administrator_id, $ids)) {
            return back()->with("error", "Acceso denegado.");
        }
        $request->merge(['discipline_id' => $discipline->id]);

        $validatedData = $request->validate([
            'dni' => 'required|integer|exists:people,dni',
            'discipline_id' => 'required|integer|exists:disciplines,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string|max:50',
            'reference_number' => 'prohibited_if:method,Efectivo|nullable|string|max:50|regex:/^[0-9]+$/',
            'receipt' => 'prohibited_if:method,Efectivo|nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'dni.exists' => 'La cédula ingresada no existe en el sistema.',
            'reference_number.prohibited_if' => 'No debe ingresar referencia si paga en Efectivo.',
            'reference_number.regex' => 'La referencia solo puede contener números.',
            'receipt.prohibited_if' => 'No debe subir comprobante si paga en Efectivo.',
            'receipt.mimes' => 'El comprobante debe ser una imagen (JPG, PNG) o PDF.'
        ]);

        try {
            $student = Student::where('discipline_id', $discipline->id)
            ->whereHas('person', function($query) use ($validatedData) {
            $query->where('dni', $validatedData['dni']);
            })->first();

            if (!$student) {
                return back()->with('error', 'El estudiante no está inscrito en esta disciplina.')
                ->withInput();
            }

            $receiptPath = null;
            if ($request->hasFile('receipt')) {
                $receiptPath = $request->file('receipt')->store('receipts', 'public');
            }

            Payment::create([
                'student_id'  => $student->id,
                'discipline_id' => $discipline->id,
                'date' => $validatedData['date'],
                'method' => $validatedData['method'],
                'amount' => $validatedData['amount'],
                'reference_number' => $validatedData['reference_number'] ?? null,
                'receipt_path' => $receiptPath,
            ]);

            return redirect()
                ->route('payment.index', $discipline)
                ->with('success', 'Pago registrado correctamente');

        } catch (\Exception $e) {
            Log::error("Error registrando el pago: " . $e->getMessage());
            return back()
                ->with('error', 'Ocurrió un error al registrar el pago: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function getPersonByDni(Request $request, Discipline $discipline){
        $ids = Auth::user()->keys();
        if (!in_array($discipline->administrator_id, $ids)) {
            return response()->json(null, 404);
        }

        $dni = $request->input('dni');
        if(!$dni) return response()->json(null, 400);

        $student = Student::with('person')
            ->where('discipline_id', $discipline->id)
            ->whereHas('person', function($q) use ($dni){
            $q->where('dni', $dni);
            })->first();

        if ($student && $student->person) {
            return response()->json([
                'found' => true,
                'student_id' => $student->id,
                'name' => $student->person->name,
                'lastname' => $student->person->lastname
            ]);
        }

        return response()->json(null, 404);
    }
}
