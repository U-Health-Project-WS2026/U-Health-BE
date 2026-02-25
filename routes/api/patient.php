<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\PatientBookingController;


Route::middleware('auth:sanctum') //User must be auth
->prefix('patients') //api request begins with patients/...
->group(function(){

    //show all available time slots
    Route::get('bookings', [PatientBookingController::class, 'viewBookedTimeSlots']);

    //search treatment by date
    Route::get('treatments/date', [\App\Http\Controllers\Patient\PatientTreatmentController::class, 'searchTreatmentDate']);

    //personal Infos
    Route::get('me', [PatientController::class, 'show_my_info']);

    //delete personal Infos
    Route::delete('delete/me', [PatientController::class, 'delete_my_account']);

    //book an appointment
    Route::put('bookings/{id}', [PatientBookingController::class, 'bookAppointment']);

    //cancel an appointment
    Route::put('bookings/cancel/{id}', [PatientBookingController::class, 'cancelAppointment']);
});

