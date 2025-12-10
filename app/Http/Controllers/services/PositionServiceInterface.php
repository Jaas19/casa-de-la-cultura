<?php

namespace App\Http\Controllers\Services;
use App\Models\Position;
use Illuminate\Http\Request;

interface PositionServiceInterface{
    public function listPositions();
}
