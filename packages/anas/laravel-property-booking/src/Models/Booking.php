<?php

namespace Anas\PropertyBooking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'user_id',
        'start_date',
        'end_date',
        'status',
        'special_request',
    ];

    // العلاقة مع العقار
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // العلاقة مع المستخدم (الضيف)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
