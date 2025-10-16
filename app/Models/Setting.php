<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'app_name', 'email', 'phone', 'address', 'logo', 'favicon'
    ];

    public function getLogoUrlAttribute()
{
    return $this->logo ? asset('storage/' . $this->logo) : asset('default-logo.png');
}

}
