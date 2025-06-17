<?php

namespace Anas\PropertyBooking\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;
use Anas\PropertyBooking\PropertyBookingServiceProvider;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;


class PropertyAvMigrationTest extends TestCase
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
        $this->assertTrue(Schema::hasTable('property_availabilities'));

        $this->assertTrue(Schema::hasColumns('property_availabilities', [
            'property_id',
            'date',
            'is_available',
            'created_at', 'updated_at'
        ]));
    }
}
