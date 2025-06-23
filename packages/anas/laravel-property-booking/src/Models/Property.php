<?php

namespace Anas\PropertyBooking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'capacity',
        'price_per_night',
    ];

    public function host()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function availabilities()
    {
        return $this->hasMany(PropertyAvailability::class);
    }

    public function pricingRules()
    {
        return $this->hasMany(PropertyPricingRule::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailableForDates($startDate, $endDate): bool
    {
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);

        $daysCount = $start->diffInDays($end);

        // عدد الأيام المتوقع توفرها
        $expected = $daysCount;

        // نتحقق من أن كل يوم بين start و end متوفر (is_available = 1)
        $availableCount = $this->availabilities()
            ->where('date', '>=', $start->toDateString())
            ->where('date', '<', $end->toDateString())
            ->where('is_available', true)
            ->count();

        return $availableCount === $expected;
    }

}
