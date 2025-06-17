<?php

namespace Anas\PropertyBooking\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Anas\PropertyBooking\Models\PropertyAvailability;

class PropertyAvailabilityController extends Controller
{
    // عرض كل التوافر لعقار معين (مثلاً)
    public function index(Request $request)
    {
        // يمكن تمرير property_id كفلتر اختياري
        $propertyId = $request->query('property_id');

        $query = PropertyAvailability::query();

        if ($propertyId) {
            $query->where('property_id', $propertyId);
        }

        $availabilities = $query->get();

        return response()->json($availabilities);
    }

    // إنشاء سجل جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'date' => 'required|date',
            'is_available' => 'required|boolean',
        ]);

        $availability = PropertyAvailability::create($validated);

        return response()->json($availability, 201);
    }

    // عرض سجل معين
    public function show($id)
    {
        $availability = PropertyAvailability::find($id);
        if (!$availability) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($availability);
    }

    // تحديث سجل التوافر
    public function update(Request $request, $id)
    {
        $availability = PropertyAvailability::find($id);
        if (!$availability) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validated = $request->validate([
            'property_id' => 'sometimes|exists:properties,id',
            'date' => 'sometimes|date',
            'is_available' => 'sometimes|boolean',
        ]);

        $availability->update($validated);

        return response()->json($availability);
    }

    // حذف سجل التوافر
    public function destroy($id)
    {
        $availability = PropertyAvailability::find($id);
        if (!$availability) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $availability->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
