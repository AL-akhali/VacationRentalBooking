<?php

namespace Anas\PropertyBooking\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;
use Anas\PropertyBooking\PropertyBookingServiceProvider;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;


class BookingMigrationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    protected function getPackageProviders($app): array
    {
        return [PropertyBookingServiceProvider::class];
    }
    #[Test]
    protected function setUp(): void
    {
        parent::setUp();

        // Load package migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    #[Test]
    public function property_table_is_created(): void
    {
        $this->assertTrue(Schema::hasTable('bookings'));

        $this->assertTrue(Schema::hasColumns('bookings', [
            'id',
            'property_id',
            'user_id',
            'start_date',
            'end_date',
            'status',
            'special_request',
            'created_at',
            'updated_at'
        ]));
    }
}
