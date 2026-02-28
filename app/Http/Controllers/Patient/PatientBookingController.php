<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminBookingResource;
use App\Models\Booking;
use App\Models\Patient;
use http\Client\Curl\User;
use Illuminate\Http\Request;


class PatientBookingController extends Controller
{
    /**
     * Patient: View available timeslots
     * GET /api/v1/patients/bookings
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function viewBookedTimeSlots()
    {
        //show the time slots with status 0=available, ordered by time_slot_start
        $bookedTimeSlots = Booking::where('status', 0)
            ->where('time_slot_start', '>=', now())
            ->orderBy('time_slot_start')
            ->get();

        return AdminBookingResource::collection($bookedTimeSlots);
    }


    /**
     * Patient: Book an appointment
     * PUT /api/v1/patients/bookings/{id}
     * @param Request $request
     * @param int $booking_id
     * @return string
     */
    public function bookAppointment(Request $request, int $booking_id)
    {
        $user_id = $request->user()
            ->user_id;

        $patient_id = Patient::where('user_id', $user_id)
            ->firstOrFail()
            ->patient_id
        ;

        //check if its a valid timeslot
        $bookedSlot = Booking::findOrFail($booking_id);

        //update the timeslot
        $bookedSlot->patient_id = $patient_id;
        $bookedSlot->status = 1;
        $bookedSlot->save();


        return "Appointment was booked";

    }


    /**
     * Patient: Cancel an appointment
     * PUT /api/v1/patients/bookings/cancel/{id}
     * @param int $booking_id
     * @return string
     */
    public function cancelAppointment(int $booking_id)
    {
        $bookedSlot = Booking::findOrFail($booking_id);

        //update the timeslot
        $bookedSlot->patient_id = null;
        $bookedSlot->status = 0;
        $bookedSlot->save();


        return "Appointment was canceled";

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function myBookedTimeSlots(Request $request)
    {
        //get current user
        $user = $request->user();


        //show the time slots with status 1=booked, ordered by time_slot_start
        $bookedTimeSlots = $user->patients->bookings()
            ->where('status', 1)
            ->orderBy('time_slot_start')
            ->get();

        return AdminBookingResource::collection($bookedTimeSlots);
    }
}
