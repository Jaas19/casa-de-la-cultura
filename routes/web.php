<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\GoodController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/dashboard', [ActivityController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard.index');

Route::get('/admin/register', function () {
    return view('auth.register');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/good/create', [GoodController::class, 'create'])->name('good.create');
    Route::post('/good/create', [GoodController::class, 'store'])->name('good.store');
    Route::patch('/good/patch', [GoodController::class, 'patch'])->name('good.update');

    Route::get('/attribute/create', [AttributeController::class, 'create'])->name('attribute.create');

    // Movimientos
    Route::post('/movement/create', [MovementController::class, 'store'])->name('movement.store');
    

    // Actividades
    Route::get('/activity', [ActivityController::class, 'index'])->name('activity.index');
    Route::get('/activity/create', [ActivityController::class, 'create'])->name('activity.create');
    Route::post('/activity/update', [ActivityController::class, 'update'])->name('activity.update');
    Route::post('/activity/getDetails', [ActivityController::class, 'getDetails'])->name('activity.getDetails');
    Route::patch('/activity/patch', [ActivityController::class, 'updateActivity'])->name('activity.patch');
    Route::post('/activity/store', [ActivityController::class, 'store'])->name('activity.store');
    Route::post('/activity/calendar', [ActivityController::class, 'calendar'])->name('activity.calendar');
    
    //Inventario

    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::patch('/inventory/patch', [InventoryController::class, 'patch'])->name('inventory.patch');
    Route::get('/inventory/update', [InventoryController::class, 'update'])->name('inventory.update');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');

    // Persona

    Route::get('person', [PersonController::class, 'index'])->name('person.index');
    Route::get('person/create', [PersonController::class, 'create'])->name('person.create');
    Route::post('person/store', [PersonController::class, 'store'])->name('person.store');
    Route::post('person/update', [PersonController::class, 'update'])->name('person.update');
    Route::patch('person/update', [PersonController::class, 'patch'])->name('person.patch');
    Route::put('person/put', [PersonController::class, 'put'])->name('person.put');
    // Pdfs
    Route::get('person/pdf', [PersonController::class, 'pdf'])->name('person.pdf');
    Route::put('person/put2', [PersonController::class, 'put2'])->name('person.put2');

    // Prestamos
    Route::get('loan', [LoanController::class, 'index'])->name('loan.index');
});

require __DIR__.'/auth.php';
