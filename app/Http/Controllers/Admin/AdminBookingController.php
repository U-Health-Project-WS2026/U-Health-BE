<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminBookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    /**
     * Admin: alle Buchungen (History) sehen.
     * GET /api/v1/admin/bookings
     */
    public function index()
    {
        $bookings = Booking::orderBy('time_slot_start', 'desc')->get();

        return AdminBookingResource::collection($bookings);
    }

    /**
     * Admin: Buchungshistorie eines bestimmten Patienten.
     * GET /api/v1/admin/bookings/patient/{patientId}
     */
    public function byPatient(int $patientId)
    {
        $bookings = Booking::where('patient_id', $patientId)
            ->orderBy('time_slot_start', 'desc')
            ->get();

        return AdminBookingResource::collection($bookings);
    }

    /**
     * Admin: Create available timeslot
     * POST api/v1/admin/bookings/slots
     */
    public function createTimeSlot(Request $request)
    {
        //Validating the data thats being send
        $validated = $request->validate([
            'time_slot_start' => 'required|date|after:now',
            'time_slot_end' => 'required|date|after:time_slot_start',
        ]);

        //Looking for duplicates or overlaps of other timeslots
        $overlap = Booking::where('time_slot_start', '<', $validated['time_slot_end'])
            ->where('time_slot_end','>',$validated['time_slot_start'])
            ->exists();

        //Error Message if overlapping exists
        if ($overlap) {
            return response()->json([
                'message' => 'Timeslot overlaps with existing timeslot or already exists'
            ], 422);
        }

        //Create new timeslot with the following attributes
        $slot = Booking::create([
            'patient_id' => null,
            'time_slot_start' => $validated['time_slot_start'],
            'time_slot_end' => $validated['time_slot_end'],
            'status' => 0,
        ]);

        //Message if creation was successfully
        return response()->json([
            'message' => 'Timeslot successfully created',
            'slot' => $slot,
        ], 201);
    }

    /**
     * Admin: Update timeslot
     * PUT /api/v1/admin/bokings/slots/{booking_id}
     */
    public function updateTimeSlot(Request $request, $booking_id)
    {
        //get data from database if exists
        $slot = Booking::findOrFail($booking_id);

        //validate the data
        $validated = $request->validate([
            'time_slot_start' => 'required|date|after:now',
            'time_slot_end'   => 'required|date|after:time_slot_start',
        ]);

        //Look for overlapping
        $overlap = Booking::where('booking_id', '!=', $booking_id)
            ->where('time_slot_start', '<', $validated['time_slot_end'])
            ->where('time_slot_end', '>', $validated['time_slot_start'])
            ->exists();

        if ($overlap) {
            return response()->json([
                'message' => 'Timeslot overlaps with existing timeslot or already exists'
            ], 422);
        }

        //update timeslot
        $slot->update($validated);

        //if update was successful, send message
        return response()->json([
            'message' => 'Time slot updated',
            'slot'    => $slot
        ], 200);
    }

    /**
     * Admin: Delete time-slot
     * DELETE /api/v1/admin/bookings/slots/{booking_id}
     */
    public function deleteTimeSlot($booking_id)
    {
        //get data from database if exists
        $slot = Booking::findOrFail($booking_id);

        //delete data
        $slot->delete();

        //if deletion was successful, return message
        return response()->json([
            'message' => 'Time slot successfully deleted'
        ], 200);
    }
}
