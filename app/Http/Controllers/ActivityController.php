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
    public function index() {
        $activities = $this->activityService->listActivities(Auth::id());
        return view('activity.index', compact("activities"));
    }

    // '/dashboard'

    public function dashboard() {
        $upcomingActivities = $this->activityService->getUpcomingActivities(Auth::id());
        $username = Auth::user()->name;
        return view('dashboard', compact('upcomingActivities', 'username'));
    }
    public function create() {
        $userId = Auth::id();
        $inventoriesResponse = $this->inventoryService->listInventories($userId);
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
        $userId = Auth::id();
        $activityId = $data->input("activityId");
        $inventoriesResponse = $this->inventoryService->listInventories($userId);
        $goods = [];
        $inventories = [];

        $activityDates = $this->activityService->getActivityDates($activityId);
        $activityGoods = $this->activityService->getActivityGoods($activityId);
        $activityOrganizers = $this->activityService->getActivityPersons($activityId);

        foreach($inventoriesResponse as $inventory){
            $inventories[$inventory->id] = $inventory->name;
            $goods[$inventory->id] = $this->goodService->listGoods($inventory->id);
        }
        $activity = Activity::find($data->activityId);
        return view('activity.update', compact('activity', 'goods', 'inventories',
    'activityDates', 'activityGoods', 'activityOrganizers'));
    }

    public function store(Request $data) {
        $this -> activityService -> createActivity($data);
        return redirect('activity');
    }
    public function patch(Request $data){
        return $this -> activityService -> changeStatus($data);
    }

    public function updateActivity(Request $data){
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
