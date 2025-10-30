<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory ;
    protected $fillable = [
        'title', 'price', 'new_price', 'is_available', 'is_new',
        'sell_number', 'description', 'category_id', 'image'
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'is_new' => 'boolean',
    ];
    

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function getDiscountPercentAttribute()
{
    if (!$this->new_price || !$this->price) return 0;
    return round(100 - ($this->new_price / $this->price * 100));
}

}
