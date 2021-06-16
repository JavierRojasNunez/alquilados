<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Provinces;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    protected $table = 'pruducts';


    public function all(Request $request)
    {
        return Product::all();
    }

    public  function store(Request $request)
    {

        $product = new Product();
        $product->reference = $request->reference;
        $product->category = $request->category;
        $product->cost = $request->cost;
        $product->quantity = $request->quantity;
        $product->save();

        if ($product) {
            return $product;
        }

        return false;
    }

    public  function update(Request $request, Product $product)
    {

        $product = Product::findorfail($request->product_id);

        $product->reference = $request->reference;
        $product->category = $request->category;
        $product->cost = $request->cost;
        $product->quantity = $request->quantity;

        $product->save();

        if ($product) {
            return $product;
        }

        return false;
    }

    public  function show(Request $request, Product $product)
    {

        $product = Product::findorfail($request->product_id);

        if ($product) {
            return $product;
        }

        return false;
    }

    public  function delete(Request $request, Product $product)
    {

        $product = Product::findorfail($request->product_id);
        $product->delete();

        if ($product) {
            return $product;
        }

        return false;
    }
}