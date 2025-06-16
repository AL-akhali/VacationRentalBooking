<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;
use Anas\PropertyBooking\PropertyBookingServiceProvider;
use Illuminate\Support\Facades\Schema;

class MigrationTest extends TestCase
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
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function properties_table_is_created(): void
    {
        $this->assertTrue(Schema::hasTable('properties'));

        $this->assertTrue(Schema::hasColumns('properties', [
            'id', 'user_id', 'title', 'description', 'price_per_night', 'created_at', 'updated_at'
        ]));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function bookings_table_is_created(): void
    {
        $this->assertTrue(Schema::hasTable('bookings'));

        $this->assertTrue(Schema::hasColumns('bookings', [
            'id', 'property_id', 'user_id', 'start_date', 'end_date', 'total_price', 'created_at', 'updated_at'
        ]));
    }
}
