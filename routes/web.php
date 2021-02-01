<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('add_order',[OrderController::class , 'showForm'])->name('newOrder');
Route::post('add_order',[OrderController::class , 'insertOrder']);
Route::get('/',[OrderController::class , 'showHome']);
Route::get('list_orders',[OrderController::class , 'showOrders']);
