<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('add_order',[OrderController::class , 'showForm'])->name('newOrder');
Route::get('edit_order/{id}',[OrderController::class , 'editForm']);
Route::post('edit_order/{id}',[OrderController::class , 'editOrder']);
Route::post('add_order',[OrderController::class , 'insertOrder']);
Route::post('get_orders',[OrderController::class , 'getOrders']);
Route::post('delete_order/{id}',[OrderController::class , 'deleteOrder']);
Route::post('delete_orders',[OrderController::class , 'deleteOrders']);
Route::post('restore_order/{id}',[OrderController::class , 'restoreOrder']);
Route::get('/',[OrderController::class , 'showHome']);
Route::get('list_orders',[OrderController::class , 'showOrders'])->name('listOrders');
