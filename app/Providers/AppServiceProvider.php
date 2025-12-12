<?php

namespace App\Providers;

use App\Http\Controllers\Services\ActivityService;
use App\Http\Controllers\Services\ActivityServiceInterface;
use App\Http\Controllers\Services\ActivityDateService;
use App\Http\Controllers\Services\ActivityDateServiceInterface;
use App\Http\Controllers\Services\ActivityGoodService;
use App\Http\Controllers\Services\ActivityGoodServiceInterface;
use App\Http\Controllers\Services\ActivityHourService;
use App\Http\Controllers\Services\ActivityHourServiceInterface;
use App\Http\Controllers\Services\ActivityPersonService;
use App\Http\Controllers\Services\ActivityPersonServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\Services\GoodService;
use App\Http\Controllers\Services\GoodServiceInterface;
use App\Http\Controllers\Services\InventoryService;
use App\Http\Controllers\Services\InventoryServiceInterface;
use App\Http\Controllers\Services\MovementService;
use App\Http\Controllers\Services\MovementServiceInterface;
use App\Http\Controllers\Services\PersonService;
use App\Http\Controllers\Services\PersonServiceInterface;
use App\Http\Controllers\Services\PositionServiceInterface;
use App\Http\Controllers\Services\PositionService;
use App\Http\Controllers\Services\LoanServiceInterface;
use App\Http\Controllers\Services\LoanService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            GoodServiceInterface::class, 
            GoodService::class
        );
        $this->app->bind(
            InventoryServiceInterface::class, 
            InventoryService::class
        );
        $this->app->bind(
            MovementServiceInterface::class, 
            MovementService::class
        );
        $this->app->bind(
            ActivityServiceInterface::class, 
            ActivityService::class
        );
        $this->app->bind(
            PersonServiceInterface::class, 
            PersonService::class
        );
        $this->app->bind(
            PositionServiceInterface::class, 
            PositionService::class
        );
        $this->app->bind(
            LoanServiceInterface::class, 
            LoanService::class
        );
        
        
        /*
        $this->app->bind(
            ActivityDateServiceInterface::class, 
            ActivityDateService::class
        );
        $this->app->bind(
            ActivityGoodServiceInterface::class, 
            ActivityGoodService::class
        );
        $this->app->bind(
            ActivityHourServiceInterface::class, 
            ActivityHourService::class
        );
        $this->app->bind(
            ActivityPersonServiceInterface::class, 
            ActivityPersonService::class
        );*/
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
