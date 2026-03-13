<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function store(Request $request)
    {
        return response()->json([
            'message' => 'Order Item added successfully',
            'data' => $request->all()
        ]);
    }
}