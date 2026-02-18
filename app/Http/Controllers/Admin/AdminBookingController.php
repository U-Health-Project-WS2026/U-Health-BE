<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminBookingResource;
use App\Models\Booking;

class AdminBookingController extends Controller
{
    /**
     * Admin: alle Buchungen (History) sehen.
     * GET /api/v1/admin/bookings
     */
    public function index()
    {
        $bookings = Booking::with('patients')->get();

        return AdminBookingResource::collection($bookings);
    }

    /**
     * Admin: Buchungshistorie eines bestimmten Patienten.
     * GET /api/v1/admin/bookings/patient/{patientId}
     */
    public function byPatient(int $patientId)
    {
        $bookings = Booking::with('patients')
            ->where('patient_id', $patientId)
            ->orderBy('time_slot_start', 'desc')
            ->get();

        return AdminBookingResource::collection($bookings);
    }

    /**
     * Admin: eine Buchung löschen.
     * DELETE /api/v1/admin/bookings/{bookingId}
     */
    public function destroy(int $bookingId)
    {
        $booking = Booking::find($bookingId);

        if (! $booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking deleted']);
    }
}
