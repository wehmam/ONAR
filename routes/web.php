<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthLoginController;
use App\Http\Controllers\Backend\RegistrationController;
use App\Http\Controllers\Backend\ScheduleController;
use App\Http\Controllers\Frontend\AuthLoginController as FrontendAuthLoginController;
use App\Http\Controllers\Frontend\IndexController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class, 'home']);

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [FrontendAuthLoginController::class, 'login'])->name("login");
    Route::post('/login', [FrontendAuthLoginController::class, "loginPost"]);
    Route::get('/register', [FrontendAuthLoginController::class, "register"])->middleware("guest");
    Route::post('/register', [FrontendAuthLoginController::class, "registerNewMember"]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [IndexController::class, 'profile']);
    Route::prefix('events')->group(function () {
        Route::get('/ajax', [IndexController::class, 'seeMoreAjaxEventList']);
        Route::get('/', [IndexController::class, 'eventList']);
        Route::get('/{id}', [IndexController::class, 'eventDetail']);
    });

    Route::post('/logout', [FrontendAuthLoginController::class, "logout"]);
});



Route::prefix('backend')->group(function () {
    Route::get("/login", [AuthLoginController::class, 'index']);
    // ->middleware('guestAdmin');
    Route::post("/login", [AuthLoginController::class, 'loginPost']);
    Route::middleware(['authAdmin'])->group(function() {
        Route::post("/logout", [AuthLoginController::class, 'logout']);
        Route::get("/", function() {
            return view("backend.pages.dashboard");
        });
        Route::resource('registrations', RegistrationController::class);

        Route::get('/schedules/ajax', [ScheduleController::class, "schedulesAjaxData"]);
        Route::resource('/schedules', ScheduleController::class);
    });
});
