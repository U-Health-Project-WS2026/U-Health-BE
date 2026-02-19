<?php

use App\Http\Controllers\Admin\AdminPatientController;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminBookingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum']) //User must be auth and admin
->prefix('admin') //api request begins with admin/...
->group(function(){

    //default
    Route::get('patients', [AdminPatientController::class, 'index']);
    Route::get('patients/{id}', [AdminPatientController::class, 'show']);
    Route::delete('patients/{id}', [AdminPatientController::class, 'destroy']);


    //BOOKINGS
    //GET-REQUESTS
    //get ALL BOOKINGS - WETHER booked OR NOT
    Route::get('bookings', [AdminBookingController::class, 'index']);

    //get bookings from a specific user/patient
    Route::get('bookings/patient/{patientId}', [AdminBookingController::class, 'byPatient']);

    //view booked timeslots
    Route::get('bookings/booked', [AdminBookingController::class, 'viewBookedTimeSlots']);


    //POST/CREATE-REQUESTS
    //create booking timeslot
    Route::post('bookings', [AdminBookingController::class, 'createTimeSlot']);

    //PUT-REQUESTS
    //update booking timeslot
    Route::put('bookings/{booking_id}', [AdminBookingController::class, 'updateTimeSlot']);

    //DELETE-REQUESTS
    //delete booking timeslot
    Route::delete('bookings/{booking_id}', [AdminBookingController::class, 'deleteTimeSlot']);

});
