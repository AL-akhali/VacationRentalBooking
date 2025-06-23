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

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_PAID = 'paid';
    public const STATUS_CHECKED_IN = 'checked_in';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_REJECTED = 'rejected';

    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_CONFIRMED,
            self::STATUS_PAID,
            self::STATUS_CHECKED_IN,
            self::STATUS_CANCELLED,
            self::STATUS_REJECTED,
        ];
    }

    public function advanceStatus(): void
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                $this->status = self::STATUS_CONFIRMED;
                break;
            case self::STATUS_CONFIRMED:
                $this->status = self::STATUS_PAID;
                break;
            case self::STATUS_PAID:
                $this->status = self::STATUS_CHECKED_IN;
                break;
            default:
                return;
        }

        $this->save();
    }

}
