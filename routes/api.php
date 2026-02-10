<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1') // ALL API REQUESTS begin with api/v1/...
    ->group(function () {
        // kleine Test-Route
        Route::get('/ping', function () {
            return response()->json(['message' => 'api v1 works']);
        });

        require __DIR__ . '/api/admin.php';
        require __DIR__ . '/api/patient.php';
        require __DIR__ . '/api/auth.php';
    });
