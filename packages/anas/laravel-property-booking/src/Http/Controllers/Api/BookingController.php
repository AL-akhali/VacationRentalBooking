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

    public function pay(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_reference' => 'required|string|max:255',
        ]);

        // يمكن إضافة تحقق صلاحيات هنا

        $booking->markAsPaid($request->payment_reference);

        return response()->json([
            'message' => 'Payment successful, booking status updated to paid.',
            'booking' => $booking,
        ]);
    }

    public function hostBookings()
    {
        $user = auth()->user();

        // نجلب كل الحجوزات للعقارات التي يملكها المضيف
        $bookings = Booking::whereHas('property', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with(['property', 'user'])
            ->orderBy('start_date', 'desc')
            ->get();

        return response()->json($bookings);
    }

    public function update(Request $request, Booking $booking)
    {
        $user = auth()->user();

        // تحقق: فقط مالك العقار يمكنه التحديث
        if ($booking->property->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'in:' . implode(',', Booking::statuses()),
            'special_request' => 'string|nullable|max:1000',
        ]);

        $booking->update($request->only('status', 'special_request'));

        return response()->json([
            'message' => 'Booking updated',
            'booking' => $booking,
        ]);
    }

    public function destroy(Booking $booking)
    {
        $user = auth()->user();

        // تحقق: فقط مالك العقار أو صاحب الحجز يمكنه الإلغاء
        if ($booking->property->user_id !== $user->id && $booking->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $booking->status = Booking::STATUS_CANCELLED;
        $booking->save();

        return response()->json([
            'message' => 'Booking cancelled',
            'booking' => $booking,
        ]);
    }

}
