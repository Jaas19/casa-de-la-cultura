<?php
namespace App\Http\Controllers\Services;
use Illuminate\Http\Request;


interface ActivityServiceInterface{
    public function listActivities(int $userId);
    public function changeStatus(Request $data);
    public function updateActivities();
    public function updateActivity(Request $request);
    public function createActivity(Request $data);
    public function getActivitiesColors($activities);
    public function getActivityDates($activityId);
    public function getActivityHours($dates);
    public function getActivityGoods($activityId);
    public function getActivityPersons($activityId);
    public function getActivityData($data);
    public function getActivitiesInTheMonth(Request $request);
    public function getUpcomingActivities($userId);
}