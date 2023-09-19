<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Session;

class AjaxProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product-ajax-action.product', compact('products'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $product = Product::create($validatedData);
        return response()->json(['message' => 'Product created successfully', 'product' => $product]);
    }

    public function show($id)
    {   
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return response()->json(['message' => 'Product created successfully', 'product' => $product]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validatedData);
        return response()->json(['message' => 'Product created successfully', 'product' => $product]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product created successfully']);
    }
}