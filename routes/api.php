<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get("all-room", [RoomsController::class, "index"]);
Route::post("register", [AuthController::class, "register"]);
Route::post("login-user", [AuthController::class, "loginUser"]);
Route::post("login-admin", [AuthController::class, "loginAdmin"]);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource("users", AuthController::class);
    Route::apiResource("rooms", RoomsController::class);
});
