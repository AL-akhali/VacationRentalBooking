<?php

namespace Anas\PropertyBooking\Database\Seeders;

use Anas\PropertyBooking\Database\Seeders\UserSeeder;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     *
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // Seeder المستخدمين
        $this->call([
            // UserSeeder::class,
            // PropertySeeder::class,
            // PropertyPricingRuleSeeder::class,
            // BookingSeeder::class,

        ]);

        // مستخدم ثابت
        $host = \Anas\PropertyBooking\Models\User::factory()->create([
            'name' => 'Test Host',
            'email' => 'host@example.com',
            'role' => 'host',
        ]);
    }
}
