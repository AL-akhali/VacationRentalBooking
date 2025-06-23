<?php

namespace Anas\PropertyBooking\Http\Controllers\Api;

use Anas\PropertyBooking\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PropertyController extends Controller
{
    public function index()
    {
        return response()->json(Property::with(['host', 'availabilities', 'pricingRules', 'bookings'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'         => ['required', 'exists:users,id'],
            'title'           => ['required', 'string'],
            'description'     => ['required', 'string'],
            'location'        => ['required', 'string'],
            'capacity'        => ['required', 'integer', 'min:1'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
        ]);

        $property = Property::create($validated);

        return response()->json($property, 201);
    }

    public function show(Property $property)
    {
        return response()->json($property->load(['host', 'availabilities', 'pricingRules', 'bookings']));
    }

    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'title'           => ['sometimes', 'string'],
            'description'     => ['sometimes', 'string'],
            'location'        => ['sometimes', 'string'],
            'capacity'        => ['sometimes', 'integer', 'min:1'],
            'price_per_night' => ['sometimes', 'numeric', 'min:0'],
        ]);

        $property->update($validated);

        return response()->json($property->fresh());
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

    public function checkAvailability(Request $request, Property $property)
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after:start_date'],
        ]);

        $isAvailable = $property->isAvailableForDates($validated['start_date'], $validated['end_date']);

        return response()->json([
            'available' => $isAvailable,
        ]);
    }
}
