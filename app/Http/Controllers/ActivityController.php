<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\ActivityServiceInterface;
use App\Http\Controllers\Services\GoodServiceInterface;
use App\Http\Controllers\Services\InventoryServiceInterface;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function update(Request $data) {
        if(!$data->input("activityId")){
            return redirect("/");
        }
        $ids = Auth::user()->keys();
        $activityId = $data->input("activityId");
        $inventoriesResponse = $this->inventoryService->listInventories($ids);
        $goods = [];
        $inventories = [];

        $activity = Activity::find($data->activityId);

        if (!$activity || !in_array($activity->user_id, $ids)) {
            return redirect()->route('activity.index')->with('error', 'No tienes permiso para editar esta actividad.');
        }


        $activityDates = $this->activityService->getActivityDates($activityId);
        $activityGoods = $this->activityService->getActivityGoods($activityId);
        $activityOrganizers = $this->activityService->getActivityPersons($activityId);

        foreach($inventoriesResponse as $inventory){
            $inventories[$inventory->id] = $inventory->name;
            $goods[$inventory->id] = $this->goodService->listGoods($inventory->id);
        }


        return view('activity.update', compact('activity', 'goods', 'inventories',
    'activityDates', 'activityGoods', 'activityOrganizers'));
    }

    public function store(Request $data) {
        $this -> activityService -> createActivity($data);
        return redirect('activity');
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

    public function updateActivity(Request $data){
        $activity = Activity::find($data->id);
        $ids = Auth::user()->keys();

        if (!$activity || !in_array($activity->user_id, $ids)) {
             return redirect()->route('activity.index')->with('error', 'No autorizado');
        }


        $this -> activityService -> updateActivity($data);
        return redirect('activity');
    }
    public function getDetails(Request $data){
        return $this->activityService->getActivityData($data);
    }

    public function calendar(Request $request) {
        return $this->activityService->getActivitiesInTheMonth($request);
    }
}
