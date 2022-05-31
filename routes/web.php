<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthLoginController;


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

Route::get('/', function () {
    // return view('welcome');
    return view("home.index");
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
    });
});