<?php

namespace Anas\PropertyBooking;

use Illuminate\Support\ServiceProvider;

class PropertyBookingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // تحميل المسارات، التراجم، الـ views، الـ config، الخ..
        $this->loadRoutesFrom(__DIR__.'/../routes/property-booking.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function register()
    {
        // تسجيل الخدمات أو الـ bindings
    }
}
