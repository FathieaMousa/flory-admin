<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory; // 🟢 هذا السطر هو المفتاح لحل الخطأ

    protected $fillable = ['name', 'parent_id'];

    // 🔹 علاقة التصنيفات الفرعية
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // 🔹 العلاقة مع التصنيف الأب
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // 🔹 المنتجات ضمن هذا التصنيف
    public function products()
    {
        return $this->hasMany(Product::class,'category_id');
    }
    public function allProducts()
{
    return $this->products()->with('images')->get();
}

}
