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

}
