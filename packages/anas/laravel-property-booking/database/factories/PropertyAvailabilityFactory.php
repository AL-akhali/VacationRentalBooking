<?php

namespace Database\Factories;

use Anas\PropertyBooking\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Anas\PropertyBooking\Models\PropertyAvailability>
 */
class PropertyAvailabilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'date' => now()->addDays(rand(0, 60))->toDateString(),
            'is_available' => fake()->boolean(80), // 80% الأيام متاحة
        ];
    }

}
