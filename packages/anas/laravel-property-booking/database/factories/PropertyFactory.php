<?php

namespace Database\Factories;

use Anas\PropertyBooking\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Anas\PropertyBooking\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'user_id' => User::factory(), // مضيف مرتبط
        'title' => fake()->sentence(3),
        'description' => fake()->paragraph(),
        'location' => fake()->city(),
        'capacity' => fake()->numberBetween(1, 10),
        'price_per_night' => fake()->randomFloat(2, 50, 500),
    ];
}

}
