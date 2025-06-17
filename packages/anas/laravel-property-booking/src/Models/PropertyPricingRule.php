<?php

namespace Anas\PropertyBooking\Models;

use Anas\PropertyBooking\Models\Property;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyPricingRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'min_stay',
        'max_stay',
        'check_in_time',
        'check_out_time',
    ];

    protected $casts = [
        'check_in_time' => 'datetime:H:i:s',
        'check_out_time' => 'datetime:H:i:s',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
