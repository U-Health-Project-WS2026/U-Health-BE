<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum') //User must be auth
->prefix('patients') //api request begins with patients/...
->group(function(){

    //default
    Route::get('users', function(){ return "PATIENT";});

});

