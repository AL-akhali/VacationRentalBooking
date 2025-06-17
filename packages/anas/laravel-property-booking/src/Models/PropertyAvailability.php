<?php

namespace Anas\PropertyBooking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'date',
        'is_available',
    ];

    protected $casts = [
        'date' => 'date',
        'is_available' => 'boolean',
    ];

    /**
     * Get the property that owns this availability entry.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
