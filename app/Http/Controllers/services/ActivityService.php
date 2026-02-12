<?php

namespace App\Http\Controllers\Services;
use App\Models\Good;
use App\Models\Good_Attribute;
use App\Models\Inventory;
use App\Models\Activity;
use App\Models\ActivityGood;
use App\Models\ActivityPerson;
use App\Models\ActivityDate;
use App\Models\ActivityHour;
use App\Models\AuditLog;
use App\Models\InventoryAttribute;
use Carbon\Carbon;
use DateInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;

class ActivityService implements ActivityServiceInterface {
    protected $colors1 = [
        "Suspendida" => "red-500",
        "Activa" => "purple-400",
        "En Espera" => "orange-400",
        "Completada" => "lime-400",
        "Pospuesta" => "yellow-400",
        "En Progreso" => "cyan-400",
    ];
    protected $colors2 = [
        "Suspendida" => "red-300",
        "Activa" => "purple-200",
        "En Espera" => "orange-200",
        "Completada" => "lime-200",
        "Pospuesta" => "yellow-100",
        "En Progreso" => "cyan-200",
    ];

    protected $headers;

    public function __construct() {
        date_default_timezone_set("America/Caracas");
        $this -> headers = [
        "Fechas y Horas" => [$this, "getActivityDates"],
        "Bienes" => [$this, "getActivityGoods"],
        "Organizadores" => [$this, "getActivityPersons"]
    ];
    }

    public function getActivityData($data){
        return $this -> headers[$data -> header]($data -> id);
    }

    public function listActivities(array $ids, ?string $status = null, ?string $search = null) {
        $this->updateActivities();

        $query = Activity::whereIn("user_id", $ids)
                        ->distinct()
                        ->orderBy('created_at', 'desc');

        if ($status && $status !== 'Todas') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $paginator = $query->paginate(30);

        $activities = $paginator->getCollection();

        if ($activities->isNotEmpty()) {
            $ids = $this->getActivitiesIds($activities);

            $this->checkActivityDates($ids, $activities);
            $this->checkActivityGoods($ids, $activities);
            $this->checkActivityPersons($ids, $activities);

            $this->getActivitiesColors($activities);
            $this->formatDates($activities);
            $this->formatHours($activities);
        }

        return $paginator;
    }

    public function getActivitiesColors($activities){
        foreach($activities as $activity){
            $activity -> color1 = $this->colors1[$activity->status];
            $activity -> color2 = $this->colors2[$activity->status];
        }
    }

    public function formatDates($activities){
        foreach($activities as $activity){
            $activity -> starting_date = $this->formatDate($activity -> starting_date);
            $activity -> ending_date = $this->formatDate($activity -> ending_date);
        }
    }

    public function formatSimpleDates($dates){
        foreach($dates as $date){
            $date -> date = date("d/m/Y", strtotime($date -> date));
        }
    }

    public function formatHour($hour){
        return date("g:i a", strtotime($hour));
    }

    public function formatDate($date){
        return date("d/m/Y", strtotime($date));
    }

    public function formatHours($hours){
        foreach($hours as $hour){
                $hour->starting_time = $this->formatHour($hour->starting_time);
                $hour->ending_time = $this->formatHour($hour->ending_time);
        }
    }

    public function createActivity(Request $request){

        return DB::transaction(function () use ($request) {
                $data = $request->only(['name', 'status']);
                $data['important'] = $request->has('important') ? 1 : 0;
                $data['user_id'] = Auth::id();
                $activity = Activity::create($data);

                $this->saveActivityDetails($activity, $request);

                return $activity;
            });
    }

    private function saveActivityDetails(Activity $activity, Request $request)
    {
        foreach ($request->input('date') as $key => $date) {
            if (empty($date['date'])){
                continue;
            }
            $activityDate = $activity->dates()->create([
                'date' => $date['date']
            ]);
            if (isset($date['starting_time'])) {
                $hours = [];
                foreach ($date['starting_time'] as $i => $starting_time) {
                    $hours[] = [
                        'starting_time' => $starting_time,
                        'ending_time'   => $date['ending_time'][$i] ?? null,
                    ];
                }
                $activityDate->hours()->createMany($hours);
            }
        }


        if ($request->has('good_id')) {
            $goods = [];
            $quantities = $request->input('quantity_requested');

            foreach ($request->input('good_id') as $key => $goodId) {
                $goods[] = [
                    'good_id' => $goodId,
                    'quantity_requested' => $quantities[$key] ?? 1,
                ];
            }
            $activity->goods()->createMany($goods);
        }


        if ($request->has('organizer_name')) {
            $organizers = [];
            foreach ($request->input('organizer_name') as $name) {
                if(!empty($name)) {
                    $organizers[] = ['name' => $name];
                }
            }
            $activity->organizers()->createMany($organizers);
        }
    }

    public function updateActivity(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $activity = Activity::findOrFail($request->id);
            $oldActivity = $activity->replicate();
            $oldName = $oldActivity->name;

            $data = $request->only(['name', 'status']);
            $data['important'] = $request->has('important') ? 1 : 0;
            $activity->update($data);

            $dateIds = $activity->dates()->pluck('id');
            ActivityHour::whereIn('date_id', $dateIds)->delete();

            $activity->dates()->delete();
            $activity->goods()->delete();
            $activity->organizers()->delete();

            $this->saveActivityDetails($activity, $request);

            if ($activity->user_id != Auth::id()) {
                AuditLog::create([
                    "giver_id" => $activity->user_id,
                    "collaborator_id" => Auth::id(),
                    "model_changed" => "Actividad: $oldName",
                    "type" => "Actualización"
                ]);
            }

            return $activity;
        });
    }

    public function changeStatus(Request $data){
        $activity = Activity::where("id", "=", $data->id)
        ->first();
        $activity->status = $data->status;
        $databaseFormat = "Y-m-d";
        $activity->save();
        return response()->json([
        'success' => true,
        'message' => 'Estado actualizado correctamente',
        'data' => $activity
    ]);
    }
    // this won't work for now, must be edited
    public function updateActivities(){
        /*
        Activity::where("ending_date", "=", date("Y-m-d"))
        ->where("ending_time", "<=", date("H:i:s"))
        ->where("status", "!=", "Completada")
        ->where("status", "!=", "Suspendida")
        ->orWhere("ending_date", "<", date("Y-m-d"))
        ->where("status", "!=", "Completada")
        ->where("status", "!=", "Suspendida")
        ->update(["status" => "En Espera"]);

        Activity::where("starting_date", "=", date("Y-m-d"))
        ->where("starting_time", "<=", date("H:i:s"))
        ->where("status", "!=", "Completada")
        ->where("status", "!=", "Suspendida")
        ->where("ending_date", ">=", date("Y-m-d"))
        ->where("ending_time", ">", date("H:i:s"))
        ->update(["status" => "En Progreso"]);
        */
    }

    public function getActivitiesIds($activities){
        $ids = [];
        foreach($activities as $activity){
            $ids[] = $activity->id;
        }
        return $ids;
    }

    public function checkActivityDates($activitiesIds, $activities){
        $activitiesWithMultipleDates = ActivityDate::whereIn('activity_id', $activitiesIds)->pluck('activity_id')->toArray();

        foreach($activities as $activity){
            in_array($activity->id, $activitiesWithMultipleDates)
            ? $activity->hasMultipleDates = true
            : $activity->hasMultipleDates = false;
        }
        return $activities;
    }
    public function checkActivityGoods($activitiesIds, $activities){
        $activitiesWithMultipleGoods = ActivityGood::whereIn('activity_id', $activitiesIds)->pluck('activity_id')->toArray();

        foreach($activities as $activity){
            in_array($activity->id, $activitiesWithMultipleGoods)
            ? $activity->hasMultipleGoods = true
            : $activity->hasMultipleGoods = false;
        }
        return $activities;
    }
    public function checkActivityPersons($activitiesIds, $activities){
        $activitiesWithPersons = ActivityPerson::whereIn('activity_id', $activitiesIds)->pluck('activity_id')->toArray();

        foreach($activities as $activity){
            in_array($activity->id, $activitiesWithPersons)
            ? $activity->hasPersons = true
            : $activity->hasPersons = false;
        }
        return $activities;
    }

    public function getActivityDates($activityId){
        $dates = ActivityDate::where("activity_id", "=", $activityId)->get();
        $hours = $this -> getActivityHours($dates);
        $this->formatSimpleDates($dates);
        foreach($hours as $hourArray){
        $this->formatHours($hourArray);
        }
        return [
            "dates" => $dates,
            "hours" => $hours
        ];
    }
    public function getActivityHours($activityDates){
        $ids = [];
        foreach($activityDates as $activityDate){
            $ids[] = $activityDate -> id;
        }
        $activityHours = ActivityHour::whereIn('date_id', $ids)->get();
        $hoursById = [];
        foreach ($activityHours as $activityHour){
            $hoursById[$activityHour->date_id][] = $activityHour;
        }
        return $hoursById;
    }
    public function getActivityGoods($activityId){
        return ActivityGood::where("activity_id", "=", $activityId)
        ->join('goods', 'goods.id', '=', 'activity_goods.good_id')
        ->join('inventories', 'goods.inventory_id', '=', 'inventories.id')
        ->select('goods.name as goodName', 'inventories.name as inventoryName', 'activity_goods.*')
        ->get();
    }
    public function getActivityPersons($activityId){
        return ActivityPerson::where("activity_id", "=", $activityId)->get();
    }

    public function getActivitiesInTheMonth(Request $request){
        $date = Carbon::parse($request -> date);

        $extraActivities = ActivityDate::whereYear('date', $date->year)
        ->whereMonth('date', $date->month)
        ->with('activity')
        ->with('hours')
        ->get();

        $formattedExtraActivities = $extraActivities->map([$this, 'formatExtraDates']);


        $allActivities = $formattedExtraActivities;


        $activities = $allActivities->groupBy([$this, 'parseByDay']);

        return response()->json([
            'month' => ucfirst($date->locale('es')->monthName),
            'year' => $date->year,
            'activities' => $activities
    ]);
    }
    public function parseByDay($activity){
        return Carbon::parse($activity->starting_date)->day;
    }

    public function formatSingleActivityHour($hour) {
        return [
            'starting_time' => $this->formatHour($hour->starting_time),
            'ending_time'   => $this->formatHour($hour->ending_time),
            'id'            => $hour->id
        ];
    }

    public function formatExtraDates($date, $day){

        $formattedHours = $date->hours->map([$this, "formatSingleActivityHour"]);
        return (object) [
            'color1' => $this->colors1[$date->activity->status] ?? 'gray-400',
            'color2' => $this->colors2[$date->activity->status] ?? 'gray-400',
            'time_array' => true,
            'name' => ($date->name ?? optional($date->activity)->name ?? 'Sin nombre'),
            'status' => optional($date->activity)->status,
            'hours' => $formattedHours,
            'starting_time' => $this->formatHour($date->hours->first()?->starting_time),
            'ending_time' => $this->formatHour($date->hours->first()?->ending_time),
            'starting_date' => Carbon::parse($date->date),
            'id' => $date->id,
        ];
    }

public function getUpcomingActivities(){

        $from = now()->copy()->startOfDay();
        $to = now()->copy()->addDays(7)->endOfDay();

        $extraActivities = ActivityDate::whereBetween("date", [$from, $to])
        ->whereHas('activity', function ($query) {
            $query->where('important', 1);
        })
        ->with('activity')
        ->get();

        $formattedExtraActivities = $extraActivities->map([$this, 'formatExtraDates']);

        $allActivities = $formattedExtraActivities;

        return $allActivities->groupBy(function($activity){
            return $this->parseByDay($activity);
        });
    }
}
