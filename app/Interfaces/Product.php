<?php

namespace App\Interfaces;

interface Product
{
    public function setProduct(array $product);
    public function setvariant( array $variant);
    public function setshippingMethod(array $shippingMethod);
    public function build();

}
