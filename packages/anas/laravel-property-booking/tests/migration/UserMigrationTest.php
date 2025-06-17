<?php

namespace Anas\PropertyBooking\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;
use Anas\PropertyBooking\PropertyBookingServiceProvider;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;


class UserMigrationTest extends TestCase
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
    public function users_table_is_created(): void
    {
        $this->assertTrue(Schema::hasTable('users'));

        $this->assertTrue(Schema::hasColumns('users', [
            'id', 'name', 'email', 'email_verified_at', 'password', 'role', 'created_at', 'updated_at'
        ]));
    }

    #[Test]
    public function sessions_table_is_created(): void
    {
        $this->assertTrue(Schema::hasTable('sessions'));

        $this->assertTrue(Schema::hasColumns('sessions', [
            'id', 'user_id', 'ip_address', 'user_agent', 'payload', 'last_activity'
        ]));
    }
}
