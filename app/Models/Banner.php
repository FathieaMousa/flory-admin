<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = ['image', 'title', 'link', 'is_active', 'order'];

    protected $casts = ['is_active' => 'boolean'];
}
