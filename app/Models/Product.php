<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['products_name', 'products_type_id', 'description', 'price', 'stock', 'img_url', 'img_name'];            
}
