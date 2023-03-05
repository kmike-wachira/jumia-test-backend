<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return count(Categories::all()) > 0 ?  Categories::all() : ['message' => "no categories"];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new_category = new Categories;
        $validator = Validator::make($request->all(), [
            'category_name' => 'required'
        ]);
        if ($validator->fails()) {
            return $validator->messages();
        }
        $validated = $validator->validated();
        $new_category->category_name = $validated['category_name'];
        $new_category->save();
        return response($new_category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $new_category = Categories::find($id);
        $request->validate([
            'category_name' => 'required'
        ]);
        $new_category->category_name = $request->category_name;
        $new_category->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
