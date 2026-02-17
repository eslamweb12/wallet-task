<?php

namespace App\Services\Builders;

use App\Interfaces\Product;

class ProductBuilder implements Product
{
    public $product;
    public function __construct(){
        $this->product = new \App\Models\Product();
    }
    public function setProduct(array $product){
        $this->product->name=$product['name'];
        $this->product->price=$product['price'];
        $this->product->description=$product['description'];
        $this->product->save();
        return $this;
    }
    public function setvariant( array $variant){
        foreach ($variant as $val) {
            $this->product->variants()->create([
                'size' => $val['size'],
                'color' => $val['color'],
            ]);
        }

        return $this;


    }
    public function setshippingMethod($shippingMethod){

       $this->product->shippingMethods()->sync($shippingMethod);
       return $this;
    }
    public function build(){
        return $this->product->load('variants','shippingMethods');
    }

}
