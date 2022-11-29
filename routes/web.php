<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthLoginController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CompanyController;
use App\Http\Controllers\Backend\EventController;
use App\Http\Controllers\Backend\RegistrationController;
use App\Http\Controllers\Backend\ScheduleController;
use App\Http\Controllers\Frontend\AuthLoginController as FrontendAuthLoginController;
use App\Http\Controllers\Frontend\IndexController;
use App\Models\AdminUser;
use App\Models\Event;
use App\Models\Registration;

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
    Route::get('creator', [FrontendAuthLoginController::class, "registerCreator"]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [IndexController::class, 'profile']);
    Route::prefix('events')->group(function () {
        Route::get('/ajax', [IndexController::class, 'seeMoreAjaxEventList']);
        Route::get('/', [IndexController::class, 'eventList']);
        Route::get('/{id}', [IndexController::class, 'eventDetail']);
        Route::get('/pay/{invoice?}', [IndexController::class, 'paymentEvents']);
        Route::post('/register', [IndexController::class, 'registEvent']);

        Route::post('do-token', [IndexController::class, 'doToken']);
    });

    Route::post('/logout', [FrontendAuthLoginController::class, "logout"]);
});



Route::prefix('backend')->group(function () {
    Route::get("/login", [AuthLoginController::class, 'index']);
    // ->middleware('guestAdmin');
    Route::post("/register", [AuthLoginController::class, "registerNewAdmin"]);
    Route::post("/login", [AuthLoginController::class, 'loginPost']);
    Route::middleware(['authAdmin'])->group(function() {
        Route::post("/logout", [AuthLoginController::class, 'logout']);
        Route::get("/", function() {
            $totalEvent = Event::count();
            $totalAdmin = AdminUser::whereNotNull("company_id")->count();
            $totalRegister = Registration::count();
            $income = Registration::whereNotNull("paid_at")->sum("total_price");

            return view("backend.pages.dashboard", compact("totalEvent", "totalAdmin", "totalRegister", "income"));
        })->middleware("checkActivatedAdmin");

        // Route::middleware(['checkActivatedAdmin'])->group(function () {
            Route::resource('registrations', RegistrationController::class)->middleware("checkActivatedAdmin");
            // Route::get('/schedules/ajax', [ScheduleController::class, "schedulesAjaxData"]);
            Route::get('events/ajax', [EventController::class, "eventsAjaxData"]);
            Route::get('events/{id}/publish', [EventController::class, "eventsPublish"]);
            Route::resource('/schedules', ScheduleController::class);
            Route::resource('events', EventController::class)->middleware("checkActivatedAdmin");

            Route::get('companies/ajax', [CompanyController::class, "companyAjaxData"]);
            Route::resource('companies', CompanyController::class);

            Route::get('categories/ajax', [CategoryController::class, "labelsAjaxData"]);
            Route::resource('categories', CategoryController::class);
        // });
    });
});
