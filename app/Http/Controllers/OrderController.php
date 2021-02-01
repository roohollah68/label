<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function showForm()
    {
        return view('addForm');
    }

    public function insertOrder(Request $request)
    {
        Order::create($request->all());
        return redirect()->route('newOrder');
    }

    public function showHome()
    {
        return view('home');
    }

    public function showOrders()
    {
        $orders = Order::all();
        return view('orders')->with('orders',$orders);
    }
}
