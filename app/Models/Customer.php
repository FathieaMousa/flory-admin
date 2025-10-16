<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Authenticatable
{
    use HasFactory;

   protected $fillable = [
    'name', 'email', 'phone', 'password',
    'fcm_token', 'is_active', 'avatar',
    'last_login_at', 'city', 'region'
];

protected $hidden = ['password'];
protected $casts = [
    'is_active' => 'boolean',
    'last_login_at' => 'datetime'
];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function getDisplayNameAttribute()
{
    return $this->name ?? $this->phone ?? 'Customer #' . $this->id;
}

}
