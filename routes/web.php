<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('add_order',[OrderController::class , 'showForm']);
