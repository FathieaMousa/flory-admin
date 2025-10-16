<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'old_status', 'new_status'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
