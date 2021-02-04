<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class ShowOrderController extends Controller
{
    public function showOrders()
    {
        if (auth()->user()->role == 'admin') {
            $admin = true;
        }else{
            $admin = false;
        }
        return view('orders',["admin"=>$admin]);
    }

    public function getOrders()
    {
        if (auth()->user()->role == 'admin') {
            $users = User::all();
            $orders = Order::withTrashed()->get();
        }else{
            $users = [auth()->user()];
            $orders = auth()->user()->orders()->withTrashed()->get();
        }

        include ('../app/jdf.php');
        foreach ($orders as $key=>$order){
            $order->created_at_p = jdate('Y/m/d H:i' , $order->created_at->getTimestamp());
            $order->updated_at_p = jdate('Y/m/d H:i' , $order->updated_at->getTimestamp());
            $order->deleted_at?
                ($order->deleted_at_p = jdate('Y/m/d H:i' , $order->deleted_at->getTimestamp()))
                :
                ($order->deleted_at_p = $order->deleted_at);
            $orders[$key] = $order;
        }
        return [$orders , $users];
    }
}
