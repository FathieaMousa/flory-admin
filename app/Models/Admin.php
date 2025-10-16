<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'role', 'is_active', 'is_admin',
    ];

    protected $hidden = ['password', 'remember_token'];

    // ✅ تأكّد أن الدالة داخل الكلاس، وليست بعد إغلاقه
    public function isAdmin(): bool
    {
        return ($this->role ?? '') === 'admin' || (bool) ($this->is_admin ?? false);
    }
}
