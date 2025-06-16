<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;
use Anas\PropertyBooking\Models\Property;
use Anas\PropertyBooking\Models\Booking;
use Anas\PropertyBooking\PropertyBookingServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

class ModelTest extends TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app): array
    {
        return [PropertyBookingServiceProvider::class];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Load package migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Create users table if missing (dummy users table for testing)
        if (!Schema::hasTable('users')) {
            Schema::create('users', function ($table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_creates_a_property(): void
    {
        $userId = \DB::table('users')->insertGetId(['name' => 'Host']);

        $property = Property::create([
            'user_id' => $userId,
            'title' => 'Test Property',
            'description' => 'Nice house',
            'price_per_night' => 100.00,
        ]);

        $this->assertDatabaseHas('properties', ['title' => 'Test Property']);
        $this->assertInstanceOf(Property::class, $property);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_creates_a_booking_for_a_property(): void
    {
        $hostId = \DB::table('users')->insertGetId(['name' => 'Host']);
        $guestId = \DB::table('users')->insertGetId(['name' => 'Guest']);

        $property = Property::create([
            'user_id' => $hostId,
            'title' => 'Beach House',
            'description' => 'By the sea',
            'price_per_night' => 200.00,
        ]);

        $booking = Booking::create([
            'property_id' => $property->id,
            'user_id' => $guestId,
            'start_date' => Carbon::today(),
            'end_date' => Carbon::today()->addDays(3),
            'total_price' => 600.00,
        ]);

        $this->assertDatabaseHas('bookings', ['property_id' => $property->id]);
        $this->assertEquals($booking->property->id, $property->id);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function property_has_many_bookings(): void
    {
        $userId = \DB::table('users')->insertGetId(['name' => 'Host']);

        $property = Property::create([
            'user_id' => $userId,
            'title' => 'City Apartment',
            'description' => 'Modern and central',
            'price_per_night' => 150.00,
        ]);

        $property->bookings()->createMany([
            [
                'user_id' => $userId,
                'start_date' => Carbon::today(),
                'end_date' => Carbon::today()->addDays(2),
                'total_price' => 300.00,
            ],
            [
                'user_id' => $userId,
                'start_date' => Carbon::today()->addDays(5),
                'end_date' => Carbon::today()->addDays(7),
                'total_price' => 300.00,
            ],
        ]);

        $this->assertCount(2, $property->bookings);
    }
}
