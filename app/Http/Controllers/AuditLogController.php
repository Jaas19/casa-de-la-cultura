<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditLogController extends Controller
{
    public function index(){
        $logs = AuditLog::where("giver_id", Auth::id())->with("collaborator")->get();
        return view("log.index", compact("logs"));
    }
}
