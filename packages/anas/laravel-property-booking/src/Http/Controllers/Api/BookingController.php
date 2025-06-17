<?php

namespace Anas\PropertyBooking\Http\Controllers\Api;

use Anas\PropertyBooking\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function index()
    {
        return response()->json(Booking::with(['property', 'user'])->get());
    }

    public function show($id)
    {
        $booking = Booking::with(['property', 'user'])->findOrFail($id);
        return response()->json($booking);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'special_request' => 'nullable|string',
        ]);

        $booking = Booking::create([
            ...$validated,
            'status' => 'pending', // الوضع الافتراضي
        ]);

        return response()->json($booking, 201);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_date',
            'status' => 'sometimes|string',
            'special_request' => 'nullable|string',
        ]);

        $booking->update($validated);

        return response()->json($booking);
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json(['message' => 'Booking deleted']);
    }
}
