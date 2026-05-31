<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'slug', 'description', 'price', 'stock', 'image', 'is_visible', 'user_id', 'category_id'];
}
