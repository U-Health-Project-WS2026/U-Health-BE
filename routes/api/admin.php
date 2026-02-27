<?php

use App\Http\Controllers\Admin\AdminPatientController;
use App\Http\Controllers\Admin\AdminBookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDiseaseController;
use App\Http\Controllers\Admin\AdminMedicationController;
use App\Http\Controllers\Admin\AdminTreatmentController;

Route::middleware(['auth:sanctum']) //User must be auth and admin
->prefix('admin') //api request begins with admin/...
->group(function(){

    //PATIENTS
    //Get ALL patients
    Route::get('patients', [AdminPatientController::class, 'index']);

    //Get a specific patients
    Route::get('patients/{id}', [AdminPatientController::class, 'show']);

    //Delete a specific patient
    Route::delete('patients/{id}', [AdminPatientController::class, 'destroy']);


    //BOOKINGS
    //get ALL BOOKINGS from past and future - WETHER booked OR NOT
    Route::get('bookings', [AdminBookingController::class, 'index']);

    //get bookings from a specific user/patient
    Route::get('bookings/patient/{id}', [AdminBookingController::class, 'byPatient']);

    //get ALL BOOKED Slots from NOW - Future // NOT BOOKINGS FROM PAST
    Route::get('bookings/booked', [AdminBookingController::class, 'viewBookedTimeSlots']);

    //Search the booked timeslot by patient name - QUERY ?name=
    Route::get('bookings/search', [AdminBookingController::class, 'searchBookedTimeSlots']);

    //create new timeslot
    Route::post('bookings', [AdminBookingController::class, 'createTimeSlot']);

    //update booking timeslot
    Route::put('bookings/{id}', [AdminBookingController::class, 'updateTimeSlot']);

    //delete booking timeslot
    Route::delete('bookings/{id}', [AdminBookingController::class, 'deleteTimeSlot']);

    //TREATMENT
    //get all treatments
    Route::get('treatments', [AdminTreatmentController::class, 'index']);

    //create a treatment with the disease and medication, find an disease_id or medication_id by its name and create the pivot table
    Route::post('treatments', [AdminTreatmentController::class, 'store']);


    //MEDICATION
    //GET ALL Medications, GET One (by ID), Create new Medication, Patch a Medication, Delete Medication (by ID)
    Route::apiResource('medications', AdminMedicationController::class);

    //DISEASES
    //GET ALL Diseases, GET One (by ID), Create new Disease, Patch a Disease, Delete Disease (by ID)
    Route::apiResource('diseases', AdminDiseaseController::class);


    //Treatments
    // 1) Create
    Route::post('/treatments', [AdminTreatmentController::class, 'store']);

    // 2) Update
    Route::patch('/treatments/{treatment}', [AdminTreatmentController::class, 'update']);

    // 3) Search by date
    Route::get('/treatments/search/by-date', [AdminTreatmentController::class, 'searchByDate']);

    // 4) History by patient id
    Route::get('/patients/{patientId}/treatments', [AdminTreatmentController::class, 'historyByPatient']);

});
