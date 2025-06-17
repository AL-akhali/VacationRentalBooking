<?php

namespace Anas\PropertyBooking\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;
use Anas\PropertyBooking\PropertyBookingServiceProvider;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;


class PropertyMigrationTest extends TestCase
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

    #[Test]
    public function property_table_is_created(): void
    {
        $this->assertTrue(Schema::hasTable('properties'));

        $this->assertTrue(Schema::hasColumns('properties', [
            'user_id',
            'title',
            'description',
            'location',
            'capacity',
            'price_per_night',
            'created_at', 'updated_at'
        ]));
    }
}
