<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product; 

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

    $data = $request->all();

    if (!is_array($data)) {
        return response()->json([
            'message' => 'Array of products required'
        ], 422);
    }

    $created = [];

    foreach ($data as $item) {

        $validated = validator($item, [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ])->validate();

        $created[] = Product::create($validated);
    }

    return response()->json([
        'message' => '10 products inserted successfully',
        'data' => $created
    ]);
});
Route::put('/products/{id}', function (Request $request, $id) {

    $product = Product::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
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