<?php

use App\Http\Controllers\Admin\AdminPatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum']) //User must be auth and admin
->prefix('admin') //api request begins with admin/...
->group(function(){

    //default
    Route::get('patients', [AdminPatientController::class, 'index']);
    Route::get('patients/{id}', [AdminPatientController::class, 'show']);
    Route::delete('patients/{id}', [AdminPatientController::class, 'destroy']);
    
});