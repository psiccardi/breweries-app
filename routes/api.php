<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeersController;
use App\Http\Controllers\BreweriesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['customSanctumAuthentication', 'locale'])->group(function () {
    Route::get('/user', function (Request $request) {
        $user = $request->user();
        return $user;
    });

    Route::get("/beers", [BeersController::class, "get"])->name('api.beers');
    Route::get("/breweries", [BreweriesController::class, "get"])->name('api.beers');
    Route::post("/logout", [AuthController::class, "logout"])->name('api.logout');
});

Route::middleware('locale')->group(function () {
    Route::post("/login", [AuthController::class, "login"])->name('api.login');
});
