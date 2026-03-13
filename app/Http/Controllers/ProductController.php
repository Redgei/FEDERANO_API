<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all());
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
        ]);

        $product->update($validated);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }

   public function destroy($id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }

    $product->delete();

    return response()->json([
        'message' => 'Product deleted successfully',
        'deleted_product_id' => $id
    ]);
}

  public function search($name = null)
{
    if ($name) {
        $products = Product::where('name', 'LIKE', "%{$name}%")->get();

       
        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }
    } else {
        $products = Product::all();
    }

    return response()->json([
        'products' => $products
    ]);
}
}