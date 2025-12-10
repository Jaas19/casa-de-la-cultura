<?php 
namespace App\Http\Controllers\Services;

use App\Http\Controllers\Services\PositionServiceInterface;
use App\Models\Position;

class PositionService implements PositionServiceInterface {
    public function listPositions()
    {
        return Position::get();
    }
}

