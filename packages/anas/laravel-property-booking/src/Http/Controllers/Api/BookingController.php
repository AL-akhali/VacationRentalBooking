<?php

namespace Anas\PropertyBooking\Http\Controllers\Api;

use Anas\PropertyBooking\Models\Booking;
use Anas\PropertyBooking\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    // إنشاء حجز جديد من الضيف
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'special_request' => 'nullable|string|max:1000',
        ]);

        $property = Property::findOrFail($request->property_id);

        if (!$property->isAvailableForDates($request->start_date, $request->end_date)) {
            throw ValidationException::withMessages([
                'date_range' => 'The property is not available for the selected dates.',
            ]);
        }

        // تحقق من التوفر (ستُضاف في الفرع 08)
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'property_id' => $request->property_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'special_request' => $request->special_request,
            'status' => Booking::STATUS_PENDING,
        ]);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking,
        ]);
    }

    // عرض حجوزات الضيف الحالي
    public function myBookings()
    {
        $bookings = Booking::where('user_id', Auth::id())->with('property')->get();

        return response()->json($bookings);
    }

    // تحديث حالة الحجز (من قبل المضيف أو النظام)
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', Booking::statuses()),
        ]);

        // في مشروع حقيقي: تحقق من صلاحيات المستخدم قبل التغيير
        $booking->status = $request->status;
        $booking->save();

        return response()->json([
            'message' => 'Booking status updated',
            'booking' => $booking,
        ]);
    }
}
