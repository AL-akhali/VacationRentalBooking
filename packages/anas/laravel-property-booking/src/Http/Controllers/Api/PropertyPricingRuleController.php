<?php 

namespace Anas\PropertyBooking\Http\Controllers\Api;

use Anas\PropertyBooking\Models\Property;
use Anas\PropertyBooking\Models\PropertyPricingRule;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PropertyPricingRuleController extends Controller
{
    public function index(Property $property)
    {
        return response()->json($property->pricingRules);
    }

    public function store(Request $request, Property $property)
    {
        $validated = $request->validate([
            'min_stay' => 'required|integer|min:1',
            'max_stay' => 'required|integer|gte:min_stay',
            'check_in_time' => 'required|date_format:H:i:s',
            'check_out_time' => 'required|date_format:H:i:s',
        ]);

        $rule = $property->pricingRules()->create($validated);

        return response()->json($rule, 201);
    }

    public function update(Request $request, Property $property, PropertyPricingRule $rule)
    {
        if ($rule->property_id !== $property->id) {
            return response()->json(['message' => 'Rule does not belong to this property'], 403);
        }

        $validated = $request->validate([
            'min_stay' => 'sometimes|integer|min:1',
            'max_stay' => 'sometimes|integer|gte:min_stay',
            'check_in_time' => 'sometimes|date_format:H:i:s',
            'check_out_time' => 'sometimes|date_format:H:i:s',
        ]);

        $rule->update($validated);

        return response()->json($rule);
    }

    public function destroy(Property $property, PropertyPricingRule $rule)
    {
        if ($rule->property_id !== $property->id) {
            return response()->json(['message' => 'Rule does not belong to this property'], 403);
        }

        $rule->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
