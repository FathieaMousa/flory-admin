<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
   protected $fillable = [
    'customer_id', 'order_id', 'title', 'body', 'is_read', 'sent_at', 'type'
];


    protected $casts = [
        'is_read' => 'boolean',
        'sent_at' => 'datetime'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
