<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Order extends Model
{
 use HasFactory ;
    protected $fillable = [
        'order_number', 'customer_id', 'address_id', 'status',
        'is_payment', 'payment_method', 'sub_total', 'coupon_value',
        'coupon_id', 'total'
    ];

    protected $casts = [
        'is_payment' => 'boolean'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function coupon()
{
    return $this->belongsTo(Coupon::class);
}

public function history()
{
    return $this->hasMany(OrderStatusHistory::class);
}

}
