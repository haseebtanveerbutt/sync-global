<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class,'shopify_product_id','shopify_product_id');
    }
}
