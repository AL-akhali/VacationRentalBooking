<?php

namespace Anas\PropertyBooking\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;
use Anas\PropertyBooking\PropertyBookingServiceProvider;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;


class PropertyPricingRuleTest extends TestCase
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
        $this->assertTrue(Schema::hasTable('property_pricing_rules'));

        $this->assertTrue(Schema::hasColumns('property_pricing_rules', [
            'id',
            'property_id',
            'min_stay',
            'max_stay',
            'check_in_time',
            'check_out_time',
            'created_at',
            'updated_at'
        ]));
    }
}

