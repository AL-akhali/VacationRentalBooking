<?php

namespace Anas\PropertyBooking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = ['property_id', 'user_id', 'start_date', 'end_date', 'total_price'];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
