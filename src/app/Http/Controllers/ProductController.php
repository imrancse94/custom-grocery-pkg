<?php

namespace Imrancse94\Grocery\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Imrancse94\Grocery\app\Models\Product;

class ProductController extends Controller
{
    public function getProducts()
    {
        $products = Product::all();

        return response()->json(['products'=>$products]);
    }
}
