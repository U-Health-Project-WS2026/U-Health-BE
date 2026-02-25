<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\PatientBookingController;
use App\Http\Controllers\Patient\PatientTreatmentController;


Route::middleware('auth:sanctum') //User must be auth
->prefix('patients') //api request begins with patients/...
->group(function(){

    
    //personal Infos
    Route::get('me', [PatientController::class, 'show_my_info']);
    
    //delete USER
    Route::delete('me', [PatientController::class, 'delete_my_account']);
    
    //CHECK IF TOKEN STILL EXISTS
    Route::get('token', function(){});


    //show all available time slots
    Route::get('bookings', [PatientBookingController::class, 'viewBookedTimeSlots']);
    
    //book an appointment
    Route::put('bookings/{id}', [PatientBookingController::class, 'bookAppointment']);
    
    //cancel an appointment
    Route::put('bookings/cancel/{id}', [PatientBookingController::class, 'cancelAppointment']);
    
    
    
    //search treatment by date - QUERY ?date=...
    Route::get('treatments/date', [PatientTreatmentController::class, 'searchTreatmentDate']);
    
    //show entire patient history
    Route::get('treatments', [PatientTreatmentController::class, 'viewTreatmentHistory']);
});

