<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login-test', function () {
    $user = App\Models\User::first();
    $token = $user->createToken('api-test-token')->plainTextToken;

    return response()->json(['token' => $token]);
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/rooms', [RoomController::class, 'index']);

Route::post('/reservations', [ReservationController::class, 'store']);
Route::get('/reservations/{id}', [ReservationController::class, 'show']);
Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancel']);


//with login-test require user token
//Route::middleware('auth:sanctum')->group(function () {
//    Route::post('/reservations', [ReservationController::class, 'store']);
//    Route::get('/reservations/{id}', [ReservationController::class, 'show']);
//    Route::post('/reservations/{id}/cancel', [ReservationController::class, 'cancel']);
//});
