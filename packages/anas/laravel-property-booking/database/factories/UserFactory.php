<?php

namespace Database\Factories;

use Anas\PropertyBooking\Models\User; // ✅ تأكد من أنك تشير لموديل الباكيج
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<\Anas\PropertyBooking\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * ربط الفاكتوري بموديل المستخدم الصحيح داخل الباكيج
     */
    public function modelName(): string
    {
        return User::class;
    }

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => fake()->randomElement(['host', 'guest']),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
