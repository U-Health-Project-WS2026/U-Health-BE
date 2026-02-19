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

    Route::get('bookings', [AdminBookingController::class, 'index']);
    Route::get('bookings/patient/{patientId}', [AdminBookingController::class, 'byPatient']);

    //create booking timeslot
    Route::post('bookings', [AdminBookingController::class, 'createTimeSlot']);
    //update booking timeslot
    Route::put('bookings/{booking_id}', [AdminBookingController::class, 'updateTimeSlot']);
    //delete booking timeslot
    Route::delete('bookings/{booking_id}', [AdminBookingController::class, 'deleteTimeSlot']);
    //view booked timeslots
    Route::get('bookings', [AdminBookingController::class, 'viewBookedTimeSlots']);

});
