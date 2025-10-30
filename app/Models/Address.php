<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'name',
        'phone',
        'street',
        'city',
        'state',
        'postal_code',
        'country',
        'selected',
    ];

    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
