<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\CategoryController;

//authentication routes
Route::post('/register', [AuthController::class,'register'])->name('auth.register');
Route::post('/login', [AuthController::class,'login'])->name('auth.login');


//protected routes for POS system, accessible only to authenticated users
Route::middleware('auth:sanctum')->prefix('pos')->group(function(){

   


Route::get('/products', [ProductController::class,'index'])
        ->name('products.list');
 
Route::get('/products/search/{name?}', [ProductController::class,'search'])
        ->name('products.search');

Route::get('/categories', [CategoryController::class,'index'])
    ->name('categories.list');


//admin routes 
    Route::middleware('role:admin')->group(function(){

      
        Route::post('/products', [ProductController::class,'store'])
            ->name('products.create');

        Route::put('/products/{id}', [ProductController::class,'update'])
            ->name('products.update');

        
        Route::delete('/products/{id}', [ProductController::class,'destroy'])
            ->name('products.delete');

      
        Route::post('/categories', [CategoryController::class,'store'])
            ->name('categories.create');

    });


 //staff routes
    Route::middleware('role:staff')->group(function(){

     
        Route::post('/orders', [OrderController::class,'store'])
            ->name('orders.create');


        Route::post('/order-items', [OrderItemController::class,'store'])
            ->name('orderitems.create');

    });

});