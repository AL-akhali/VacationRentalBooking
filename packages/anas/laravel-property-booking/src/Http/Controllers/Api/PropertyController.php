<?php

namespace Anas\PropertyBooking\Http\Controllers\Api;

use Anas\PropertyBooking\Models\Property;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::all();
        return response()->json($properties);
    }

    public function show($id)
    {
        $property = Property::find($id);
        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }
        return response()->json($property);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer',
            'price_per_night' => 'required|numeric',
        ]);

        $property = Property::create($validated);

        return response()->json($property, 201);
    }

    public function update(Request $request, $id)
    {
        $property = Property::find($id);
        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'location' => 'sometimes|nullable|string|max:255',
            'capacity' => 'sometimes|nullable|integer',
            'price_per_night' => 'sometimes|required|numeric',
        ]);

        $property->update($validated);

        return response()->json($property);
    }

    public function destroy($id)
    {
        $property = Property::find($id);
        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        $property->delete();

        return response()->json(null, 204);
    }
}
