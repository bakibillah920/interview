<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'sku', 'description'
    ];
    public function ProductVariant() {
        return $this->hasMany('App\Models\ProductVariant', 'product_id');
    }
    public function ProductVariantPrice() {
        return $this->hasMany('App\Models\ProductVariantPrice', 'product_id');
    }
}
