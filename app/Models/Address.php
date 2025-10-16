<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id', 'city', 'region', 'address', 'is_default'
    ];

    protected $casts = ['is_default' => 'boolean'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    public function scopeDefault($query)
{
    return $query->where('is_default', true);
}

}
