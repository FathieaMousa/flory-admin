<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

 protected $fillable = [
    'code', 'type', 'value', 'min_order_value',
    'max_uses', 'used_count', 'start_date', 'end_date',
    'is_active', 'description'
];


    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // 🔹 التحقق من صلاحية الكوبون
    public function getIsValidAttribute()
    {
        return $this->is_active &&
               ($this->start_date == null || $this->start_date->isPast()) &&
               ($this->end_date == null || $this->end_date->isFuture()) &&
               ($this->max_uses == null || $this->used_count < $this->max_uses);
    }
}
