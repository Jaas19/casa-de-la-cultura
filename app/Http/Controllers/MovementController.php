<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\MovementService;
use Illuminate\Http\Request;
use App\Http\Controllers\Services\MovementServiceInterface;

class MovementController extends Controller
{
    protected $movementService;
    public function __construct(MovementServiceInterface $movementService){
        $this->movementService = $movementService;
    }
    public function store(Request $data) {
        return $this->movementService->registerMovement($data);
    }
}
