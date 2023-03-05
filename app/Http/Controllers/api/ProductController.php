<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return count(Products::all()) > 0 ?  Products::all() : ['message' => 'no products'];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // create the product instance
        $product = new Products;
        // validate the request
        $validator = Validator::make($request->all(), [
            'product_image' => 'required|mimes:png,jpg',
            'product_name' => 'required|min:5',
            'product_short_desc' => 'required|min:10',
            'product_desc' => 'required|min:10',
            'price' => 'required',
            'category_id' => 'required'
        ]);
        if ($validator->fails()) {
            return ['error' => $validator->messages()];
        }
        // insert image to storage
        $path = $request->file('product_image')->store('/products');
        // get validated requet data
        $validated = $validator->validated();
        // modify validated to add image path
        $validated['product_image'] = '/storage/' . $path;
        // save data to database
        $newproduct = Products::create($validated);
        return response(['message' => $newproduct], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $foundproduct = Products::findOrFail($id);
        return response($foundproduct, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
