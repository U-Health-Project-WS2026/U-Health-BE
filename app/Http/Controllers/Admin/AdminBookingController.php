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
     * GET bookings
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $bookings = Booking::orderBy('time_slot_start', 'desc')->get();

        return AdminBookingResource::collection($bookings);
    }

    /**
     * Admin: Create available timeslot
     * POST bookings
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
     * PUT bookings/{booking_id}
     * @param Request $request
     * @param $booking_id
     * @return \Illuminate\Http\JsonResponse
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
     * DELETE bookings/{booking_id}
     * @param $booking_id
     * @return \Illuminate\Http\JsonResponse
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

    /**
     * Admin: View booked timeslots
     * GET bookings/booked
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function viewBookedTimeSlots()
    {
        //show the time slots with status 1=booked, ordered by time_slot_start
        $bookedTimeSlots = Booking::where('status', 1)
            ->where('time_slot_start', '>=', now())
            ->orderBy('time_slot_start')
            ->get();

        return AdminBookingResource::collection($bookedTimeSlots);
    }

    /**
     * Admin: search booked timeslots by first- or lastname
     * GET bookings/search
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function searchBookingByName(Request $request)
    {
        //take query parameter from url
        $name = $request->query('name');

        //search after timeslots with status=1, by patients first- or last_name
        $bookedSlots = Booking::with('patients')
            ->where('status', 1)
            ->whereHas('patients', function ($query) use ($name) {
                $query->where('first_name', 'like', "%{$name}%")
                    ->orWhere('last_name', 'like', "%{$name}%");
            })
            ->orderBy('time_slot_start', 'asc')
            ->get();

        return AdminBookingResource::collection($bookedSlots);
    }

    /**
     */
    public function bookingsToday()
    {
        $bookings=Booking::whereDate('time_slot_start', today())
            ->where('status', 1)
            ->count();

        return response()->json(['message'=>$bookings],200);
    }

     * Admin: search booked timeslots by patient id
     * GET bookings/search/{id}
     * @param $patient_id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function searchByPatientID($patient_id)
    {
        $bookings = Booking::where('patient_id', $patient_id)
            ->where('status', 1)
            ->orderBy('time_slot_start', 'desc')
            ->get();

        return AdminBookingResource::collection($bookings);
    }
}
