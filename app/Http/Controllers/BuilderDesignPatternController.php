<?php

namespace App\Http\Controllers;

use App\Interfaces\Product;
use Illuminate\Http\Request;

class BuilderDesignPatternController extends Controller
{
    public function create(Product $product, Request $request){
        $newProduct=$product->setProduct($request->only(['name','description','price']))
            ->setVariant($request->input('variants', []))
            ->setShippingMethod($request->input('shipping_methods', []))
            ->build();
        return response()->json([
            'newProduct'=>$newProduct,
        ]);


    }
}
