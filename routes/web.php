<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\GoodController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PositionTypeController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [ActivityController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard.index');

Route::get('/admin/register', function () {
    return view('auth.register');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');

    // Goods
    Route::get('/good/create', [GoodController::class, 'create'])->name('good.create');
    Route::get('/good/{good}/edit', [GoodController::class, 'edit'])->name('good.edit');
    Route::post('/good/create', [GoodController::class, 'store'])->name('good.store');
    Route::patch('/good/{good}/patch', [GoodController::class, 'patch'])->name('good.update');

    // Register new user
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');

    // Close session
    Route::get('/auth/close', [AuthenticatedSessionController::class, 'destroy'])->name('session.destroy');

    Route::get('/attribute/create', [AttributeController::class, 'create'])->name('attribute.create');

    // Movements
    Route::post('/movement/create', [MovementController::class, 'store'])->name('movement.store');


    // Activities
    Route::get('/activity', [ActivityController::class, 'index'])->name('activity.index');
    Route::get('/activity/create', [ActivityController::class, 'create'])->name('activity.create');
    Route::post('/activity/update', [ActivityController::class, 'update'])->name('activity.update');
    Route::post('/activity/getDetails', [ActivityController::class, 'getDetails'])->name('activity.getDetails');
    Route::patch('/activity/patch', [ActivityController::class, 'updateActivity'])->name('activity.patch');
    Route::post('/activity/store', [ActivityController::class, 'store'])->name('activity.store');
    Route::post('/activity/calendar', [ActivityController::class, 'calendar'])->name('activity.calendar');
    Route::patch('/activity/changeStatus', [ActivityController::class, 'patch'])->name('activity.changeStatus');

    // Inventory

    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::patch('/inventory/patch', [InventoryController::class, 'patch'])->name('inventory.patch');
    Route::get('/inventory/update', [InventoryController::class, 'update'])->name('inventory.update');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::Post('/inventory/attributes', [InventoryController::class, 'attributes'])->name('inventory.attributes');

    // Persons

    Route::get('person', [PersonController::class, 'index'])->name('person.index');
    Route::get('person/create', [PersonController::class, 'create'])->name('person.create');
    Route::get('person/{person}/edit', [PersonController::class, 'edit'])->name('person.edit');
    Route::post('person/store', [PersonController::class, 'store'])->name('person.store');
    Route::post('person/update', [PersonController::class, 'update'])->name('person.update');
    Route::patch('person/update', [PersonController::class, 'patch'])->name('person.patch');
    Route::put('person/put', [PersonController::class, 'put'])->name('person.put');
    // Pdfs
    Route::get('person/pdf', [PersonController::class, 'pdf'])->name('person.pdf');
    Route::put('person/put2', [PersonController::class, 'put2'])->name('person.put2');

    // Loans
    Route::get('loan', [LoanController::class, 'index'])->name('loan.index');

    Route::patch('loan/patch', [LoanController::class, 'patch'])->name('loan.patch');
    Route::get('loan/create', [LoanController::class, 'create'])->name('loan.create');
    Route::post('loan/store', [LoanController::class, 'store'])->name('loan.store');

    // Disciplines
    Route::get('discipline', [DisciplineController::class, 'index'])->name('discipline.index');
    Route::get('discipline/create', [DisciplineController::class, 'create'])->name('discipline.create');
    Route::post('discipline/store', [DisciplineController::class, 'store'])->name('discipline.store');
    Route::patch('discipline/patch', [DisciplineController::class, 'update'])->name('discipline.patch');
    Route::get('discipline/{discipline}/edit', [DisciplineController::class, 'edit'])->name('discipline.edit');

    // Lessons
    Route::get('discipline/{discipline}/lessons', [LessonController::class, 'index'])->name('lesson.index');
    Route::get('discipline/{discipline}/calendar', [LessonController::class, 'calendar'])->name('lesson.calendar');
    Route::get('lesson/all', [LessonController::class, 'generalCalendar'])->name('lesson.general');
    Route::get('discipline/{discipline}/lesson/create', [LessonController::class, 'create'])->name('lesson.create');
    Route::post('discipline/{discipline}/lesson/create', [LessonController::class, 'store'])->name('lesson.store');
    Route::get('discipline/{discipline}/lesson/{lesson}/edit', [LessonController::class, 'edit'])->name('lesson.edit');
    Route::patch('discipline/{discipline}/lesson/{lesson}/update', [LessonController::class, 'update'])->name('lesson.update');
    Route::post('lesson/calendar', [LessonController::class, 'getCalendarLessons'])->name('lesson.month');

    // Schedules
    Route::get('discipline/{discipline}/schedule/create', [ScheduleController::class, 'create'])->name('schedule.create');
    Route::post('discipline/{discipline}/schedule/store', [ScheduleController::class, 'store'])->name('schedule.store');

    // Students
    Route::get('discipline/{discipline}/student', [StudentController::class, 'index'])->name('student.index');
    Route::get('discipline/{discipline}/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::get('discipline/{discipline}/student/{student}/edit', [StudentController::class, 'edit'])->name('student.edit');

    Route::post('discipline/{discipline}/student/store', [StudentController::class, 'store'])->name('student.store');
    Route::put('discipline/{discipline}/student/{student}/update', [StudentController::class, 'update'])->name('student.update');
    Route::patch('discipline/{discipline}/student/{student}/status', [StudentController::class, 'toggleStatus'])->name('student.toggle');
    Route::patch('discipline/{discipline}/student/{student}/payment', [StudentController::class, 'registerPayment'])->name('student.payment');

    // Position

    Route::get('position/create', [PositionController::class, 'create'])->name("position.create");
    Route::get('position/edit', [PositionController::class, 'edit'])->name("position.edit");
    Route::post('position/store', [PositionController::class, 'store'])->name("position.store");
    Route::patch('position/update', [PositionController::class, 'update'])->name("position.update");


    // PositionType

    Route::get('position_type/create', [PositionTypeController::class, 'create'])->name("position_type.create");
    Route::get('position_type/edit', [PositionTypeController::class, 'edit'])->name("position_type.edit");
    Route::post('position_type/store', [PositionTypeController::class, 'store'])->name("position_type.store");
    Route::patch('position_type/update', [PositionTypeController::class, 'update'])->name("position_type.update");

    // Payment

    Route::get('discipline/{discipline}/payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::get('discipline/{discipline}/payment/create', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('discipline/{discipline}/payment', [PaymentController::class, 'store'])->name('payment.store');
    Route::post('discipline/{discipline}/student/search', [PaymentController::class, 'getPersonByDni'])->name('student.getByDni');

    // Period

    Route::get('lesson/{lesson}/period', [PeriodController::class, 'index'])->name('period.index');
    Route::get('lesson/{lesson}/period/create', [PeriodController::class, 'create'])->name('period.create');
    Route::post('lesson/{lesson}/period', [PeriodController::class, 'store'])->name('period.store');
    Route::get('lesson/{lesson}/period/{period}', [PeriodController::class, 'edit'])->name('period.edit');
    Route::patch('lesson/{lesson}/period/{period}', [PeriodController::class, 'update'])->name('period.update');

    });
require __DIR__.'/auth.php';
