<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable = [
        'name',
        'price',
        'description',

    ];
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
    public function shippingMethods(){
        return $this->belongsToMany(ShippingMethod::class,'products_shipping_methods');
    }

}
