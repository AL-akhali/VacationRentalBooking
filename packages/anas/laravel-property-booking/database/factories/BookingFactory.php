<?php

namespace Database\Factories;

use Anas\PropertyBooking\Models\Property;
use Anas\PropertyBooking\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = \App\Models\Booking::class;

    public function definition()
    {
        // نختار مضيف وعقار عشوائيين
        $property = Property::inRandomOrder()->first() ?? Property::factory()->create();
        $user = User::where('role', 'guest')->inRandomOrder()->first() ?? User::factory()->create(['role' => 'guest']);

        // توليد تواريخ حجز
        $startDate = $this->faker->dateTimeBetween('now', '+1 month');
        $endDate = (clone $startDate)->modify('+'. $this->faker->numberBetween(1,7) .' days');

        return [
            'property_id' => $property->id,
            'user_id' => $user->id,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'paid', 'checked_in', 'cancelled']),
            'special_request' => $this->faker->optional()->sentence(),
        ];
    }
}
