<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PeripheralController;
use App\Http\Controllers\Api\TechnicianAssignmentController;
use App\Http\Controllers\Api\LoginController;

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [UserController::class, 'store']);
Route::get('get-current-user', [UserController::class, 'getCurrentUser']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('peripherals', [PeripheralController::class, 'store']);
    Route::get('peripherals', [PeripheralController::class, 'index']);
    Route::get('peripherals/{id}', [PeripheralController::class, 'show']);
    Route::get('peripherals/reported-by/{id}', [PeripheralController::class, 'getByReportedUser']);
    Route::put('peripherals/{id}/edit', [PeripheralController::class, 'update']);
    Route::delete('peripherals/{id}/delete', [PeripheralController::class, 'destroy']);

    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}/edit', [UserController::class, 'update']);
    Route::delete('users/{id}/delete', [UserController::class, 'destroy']);

    Route::post('technician-assignments', [TechnicianAssignmentController::class, 'store']);
    Route::get('technician-assignments', [TechnicianAssignmentController::class, 'index']);
    Route::get('technician-assignments/{id}', [TechnicianAssignmentController::class, 'show']);
    Route::get('technician-assignments/technician/{id}', [TechnicianAssignmentController::class, 'getByTechnician']);
    Route::get('technician-assignments/peripheral/{id}', [TechnicianAssignmentController::class, 'getByPeripheral']);
    Route::put('technician-assignments/{id}/edit', [TechnicianAssignmentController::class, 'update']);
    Route::delete('technician-assignments/{id}/delete', [TechnicianAssignmentController::class, 'destroy']);

});



