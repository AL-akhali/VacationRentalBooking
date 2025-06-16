<?php

namespace Anas\PropertyBooking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'price_per_night'];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
