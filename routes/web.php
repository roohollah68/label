<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('add_order',[OrderController::class , 'showForm']);
Route::get('/',[OrderController::class , 'showHome']);
Route::get('list_orders',[OrderController::class , 'showOrders']);
