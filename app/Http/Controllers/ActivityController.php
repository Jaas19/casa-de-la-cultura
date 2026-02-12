<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\ActivityServiceInterface;
use App\Http\Controllers\Services\GoodServiceInterface;
use App\Http\Controllers\Services\InventoryServiceInterface;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActivityController extends Controller
{
    protected $activityService;
    protected $goodService;
    protected $inventoryService;

    public function __construct(ActivityServiceInterface $activityService, GoodServiceInterface $goodService, InventoryServiceInterface $inventoryService) {
        $this->activityService = $activityService;
        $this->goodService = $goodService;
        $this->inventoryService = $inventoryService;
    }

    public function index(Request $request) {
        $status = $request->input('status', 'Todas');
        $search = $request->input('search');
        $ids = Auth::user()->keys();
        $activities = $this->activityService->listActivities($ids, $status, $search);
        return view('activity.index', compact("activities", "status", "search"));
    }

    public function dashboard() {
        $upcomingActivities = $this->activityService->getUpcomingActivities();
        $username = Auth::user()->name;
        return view('dashboard', compact('upcomingActivities', 'username'));
    }

    public function create() {
        $ids = Auth::user()->keys();
        $inventoriesResponse = $this->inventoryService->listInventories($ids);
        $goods = [];
        $inventories = [];
        foreach($inventoriesResponse as $inventory){
            $inventories[$inventory->id] = $inventory->name;
            $goods[$inventory->id] = $this->goodService->listGoods($inventory->id);
        }
        return view('activity.create', compact('goods', 'inventories'));
    }

    public function update(Activity $activity) {

        $ids = Auth::user()->keys();

        if (!$activity || !in_array($activity->user_id, $ids)) {
            return redirect()->route('activity.index')->with('error', 'No tienes permiso para editar esta actividad o no existe.');
        }

        $inventoriesResponse = $this->inventoryService->listInventories($ids);

        $activityDates = $this->activityService->getActivityDates($activity->id);
        $activityGoods = $this->activityService->getActivityGoods($activity->id);
        $activityOrganizers = $this->activityService->getActivityPersons($activity->id);

        $goods = [];
        $inventories = [];

        foreach($inventoriesResponse as $inventory){
            $inventories[$inventory->id] = $inventory->name;
            $goods[$inventory->id] = $this->goodService->listGoods($inventory->id);
        }

        return view('activity.update', compact('activity', 'goods', 'inventories',
            'activityDates', 'activityGoods', 'activityOrganizers'));
    }

    public function store(Request $request) {
        $request->validate([
        'name' => 'required|string|max:255',
        'status' => 'required|in:Suspendida,Activa,En Espera,Completada,Pospuesta,En Progreso',

        'date' => 'required|array|min:1',
        'date.*.date' => 'required|date',

        'date.*.starting_time' => 'required|array',
        'date.*.starting_time.*' => 'required',
        'date.*.ending_time' => 'required|array',
        'date.*.ending_time.*' => 'required',

        'good_id' => 'nullable|array',
        'good_id.*' => 'exists:goods,id',
        'quantity_requested' => 'nullable|array',
        'quantity_requested.*' => 'nullable|numeric|min:1',
        ], [
        'name.required' => 'El nombre de la actividad es obligatorio.',
        'status.required' => 'Debes seleccionar un estado.',
        'date.required' => 'Debes agregar al menos una fecha.',
        'date.*.date.required' => 'Falta seleccionar una fecha en el calendario.',
        'date.*.starting_time.*.required' => 'Falta una hora de inicio.',
        'date.*.ending_time.*.required' => 'Falta una hora de fin.',
        'good_id.*.exists' => 'Uno de los bienes seleccionados no es válido.',
        'quantity_requested.*.min' => 'La cantidad debe ser mayor a 0.'
        ]);

    $dates = $request->input('date', []);

    foreach ($dates as $dateIndex => $dateData) {
        if (isset($dateData['starting_time']) && isset($dateData['ending_time'])) {
            foreach ($dateData['starting_time'] as $timeIndex => $startTime) {
                $endTime = $dateData['ending_time'][$timeIndex] ?? null;

                if ($startTime && $endTime && $startTime >= $endTime) {
                    return back()->withInput()->with("error", "Las horas de inicio deben de ir antes de las horas de fin.");
                }
            }
        }
    }

    try{
        $this -> activityService -> createActivity($request);
        return redirect()->route('activity.index')->with("success", "Actividad creada exitosamente.");
    } catch (\Exception $e){
        Log::error("Error crítico al crear actividad. Usuario: " . Auth::id());
        Log::error("Mensaje: " . $e->getMessage());
        return back()->withInput()->with("error", "Error, intente de nuevo más tarde.");
    }

    }
    public function patch(Request $data){
        $activity = Activity::find($data->id);

        $ids = Auth::user()->keys();
        if (!$activity || !in_array($activity->user_id, $ids)) {
             return response()->json(['error' => 'No autorizado'], 403);
        }

        if (!$activity) {
        return response()->json(['error' => 'Actividad no encontrada'], 404);
    }
        return $this -> activityService -> changeStatus($data);
    }

public function updateActivity(Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'status' => 'required|in:Suspendida,Activa,En Espera,Completada,Pospuesta,En Progreso',

        'date' => 'required|array|min:1',
        'date.*.date' => 'required|date',

        'date.*.starting_time' => 'required|array',
        'date.*.starting_time.*' => 'required',
        'date.*.ending_time' => 'required|array',
        'date.*.ending_time.*' => 'required',

        'good_id' => 'nullable|array',
        'good_id.*' => 'exists:goods,id',
        'quantity_requested' => 'nullable|array',
        'quantity_requested.*' => 'nullable|numeric|min:1',
        ], [
        'name.required' => 'El nombre de la actividad es obligatorio.',
        'status.required' => 'Debes seleccionar un estado.',
        'date.required' => 'Debes agregar al menos una fecha.',
        'date.*.date.required' => 'Falta seleccionar una fecha en el calendario.',
        'date.*.starting_time.*.required' => 'Falta una hora de inicio.',
        'date.*.ending_time.*.required' => 'Falta una hora de fin.',
        'good_id.*.exists' => 'Uno de los bienes seleccionados no es válido.',
        'quantity_requested.*.min' => 'La cantidad debe ser mayor a 0.'
        ]);

    $dates = $request->input('date', []);
    foreach ($dates as $dateIndex => $dateData) {
        if (isset($dateData['starting_time']) && isset($dateData['ending_time'])) {
            foreach ($dateData['starting_time'] as $timeIndex => $startTime) {
                $endTime = $dateData['ending_time'][$timeIndex] ?? null;
                if ($startTime && $endTime && $startTime >= $endTime) {
                    return back()->withInput()->with("error", "Las horas de inicio deben de ir antes de las horas de fin.");
                }
            }
        }
    }

    $activity = Activity::find($request->id);
    $ids = Auth::user()->keys();

    if (!$activity || !in_array($activity->user_id, $ids)) {
        Log::warning("Intento de edición no autorizado. Usuario: " . Auth::id() . " Actividad: " . $request->id);
        return redirect()->route('activity.index')->with('error', 'No tienes permiso para editar esta actividad.');
    }

    try {
        $this->activityService->updateActivity($request);
        return redirect()->route('activity.index')->with('success', 'Actividad actualizada correctamente');

    } catch (\Exception $e) {
        Log::error("Error actualizando actividad ID " . $request->id . ": " . $e->getMessage());
        return back()->withInput()->with('error', "Error, intente de nuevo más tarde.");
    }
}
    public function getDetails(Request $data){
        return $this->activityService->getActivityData($data);
    }

    public function calendar(Request $request) {
        return $this->activityService->getActivitiesInTheMonth($request);
    }
}
