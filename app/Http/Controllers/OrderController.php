<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function showForm()
    {
        return view('addForm');
    }

    public function showHome()
    {
        return view('home');
    }

    public function showOrders()
    {
        return view('orders');
    }
}
