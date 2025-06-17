<?php

namespace Anas\PropertyBooking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isHost(): bool
    {
        return $this->role === 'host';
    }

    public function isGuest(): bool
    {
        return $this->role === 'guest';
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }


    public static function newFactory()
    {
        return \Database\Factories\UserFactory::new();
    }
}
