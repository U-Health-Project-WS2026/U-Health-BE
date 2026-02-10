<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

Route::prefix('v1')->group(function () {

    // Testroute: /api/v1/ping
    Route::get('/ping', function () {
        return response()->json(['message' => 'api v1 works']);
    });

    // Admin: Patient Management  -> /api/v1/admin/...
    Route::prefix('admin')->group(function () {
        Route::get('/patients', [PatientController::class, 'index']);
        Route::get('/patients/{id}', [PatientController::class, 'show']);
        Route::post('/patients', [PatientController::class, 'store']);
        Route::match(['put', 'patch'], '/patients/{id}', [PatientController::class, 'update']);
        Route::delete('/patients/{id}', [PatientController::class, 'destroy']);
    });

});

