<?php

use App\Http\Controllers\DeleteOrderController;
use App\Http\Controllers\EditOrderController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\NewOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShowOrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware'=>'auth'],function (){

    Route::get('add_order',[NewOrderController::class , 'showForm'])->name('newOrder');
    Route::post('add_order',[NewOrderController::class , 'insertOrder']);

    Route::get('edit_order/{id}',[EditOrderController::class , 'editForm']);
    Route::post('edit_order/{id}',[EditOrderController::class , 'editOrder']);

    Route::post('get_orders',[ShowOrderController::class , 'getOrders']);
    Route::get('list_orders',[ShowOrderController::class , 'showOrders'])->name('listOrders');

    Route::post('delete_order/{id}',[DeleteOrderController::class , 'deleteOrder']);
    Route::post('delete_orders',[DeleteOrderController::class , 'deleteOrders']);
    Route::post('restore_order/{id}',[DeleteOrderController::class , 'restoreOrder']);

    Route::get('/',[ManageUserController::class , 'home']);
    Route::get('/manage_users',[ManageUserController::class , 'show'])->name('manageUsers');
//    Route::get('/delete_user/{id}',[ManageUserController::class , 'delete']);
    Route::get('/confirm_user/{id}',[ManageUserController::class , 'confirm']);
    Route::get('/suspend_user/{id}',[ManageUserController::class , 'suspend']);
    Route::get('/edit_user/{id}',[ManageUserController::class , 'edit']);
    Route::post('/edit_user/{id}',[ManageUserController::class , 'update']);

});

require __DIR__.'/auth.php';
