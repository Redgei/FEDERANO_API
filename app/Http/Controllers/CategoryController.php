<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category created successfully',
            'category' => $category
        ], 201);
    }

    public function index()
{
    $categories = \App\Models\Category::all();

    if ($categories->isEmpty()) {
        return response()->json([
            'message' => 'No categories found'
        ], 404);
    }

    return response()->json([
        'categories' => $categories
    ]);
}
}