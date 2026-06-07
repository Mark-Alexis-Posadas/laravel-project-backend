<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Category;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', function () {
    return Product::all();
});

Route::get('/products/{id}', function ($id) {
    return Product::findOrFail($id);
});

Route::post('/products', function (Request $request) {

    $validated = $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'category_id' => 'nullable|exists:categories,id',
    ]);

    return Product::create($validated);
});

Route::put('/products/{id}', function (Request $request, $id) {

    $product = Product::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'category_id' => 'nullable|exists:categories,id',
    ]);

    $product->update($validated);

    return response()->json([
        'message' => 'Product updated successfully',
        'data' => $product
    ]);
});

Route::delete('/products/{id}', function ($id) {

    $product = Product::findOrFail($id);

    $product->delete();

    return response()->json([
        'message' => 'Product deleted successfully'
    ]);
});

Route::get('/categories', function () {
    return Category::all();
});

Route::post('/categories', function (Request $request) {

    $validated = $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
    ]);

    return Category::create($validated);
});

Route::put('/categories/{id}', function (Request $request, $id) {

    $category = Category::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
    ]);

    

    $category->update($validated);

    return $category;
});

Route::delete('/categories/{id}', function ($id) {

    $category = Category::findOrFail($id);

    $category->delete();

    return response()->json([
        'message' => 'Category deleted successfully'
    ]);
});