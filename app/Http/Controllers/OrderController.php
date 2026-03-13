<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        return response()->json([
            'message' => 'Order created successfully',
            'data' => $request->all()
        ]);
    }
}