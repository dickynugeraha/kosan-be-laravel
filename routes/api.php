<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\RoomsController;
use App\Models\Orders;
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
    Route::apiResource("users", AuthController::class);
    Route::apiResource("rooms", RoomsController::class);
    Route::post("rooms/update/{roomId}", [RoomsController::class, "updateRoom"]);
    Route::apiResource("orders", OrdersController::class);
    Route::get("orders/need-payment/{userId}", [OrdersController::class, "userOrderByWaitingPayment"]);
    Route::post("orders/update-payment", [OrdersController::class, "updatePayment"]);
    Route::get("orders/user/{userId}", [OrdersController::class, "getOrdersByUser"]);
    Route::get("orders/status/{status}", [OrdersController::class, "getOrdersByStatus"]);
});
