<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1') //ALL API REQUESTS begin with api/v1/...
->group(function () {
    require __DIR__.'/api/admin.php';
    require __DIR__.'/api/patient.php';
    require __DIR__.'/api/auth.php';
});