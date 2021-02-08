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
            $users = User::withTrashed()->get();
            $orders = Order::withTrashed()->get();
        }else{
            $users = [auth()->user()];
            $orders = auth()->user()->orders()->withTrashed()->get();
        }

        include ('../app/jdf.php');
        $dates = [];
        foreach ($orders as $key=>$order){
            $dates[$key][0] = $order->created_at->getTimestamp();
            $dates[$key][1] = $order->updated_at->getTimestamp();
            $order->deleted_at?($dates[$key][2] = $order->deleted_at->getTimestamp()):($dates[$key][2] = null);
        }
        foreach ($orders as $key=>$order){
            $order->created_at_p = jdate('Y/m/d H:i' , $dates[$key][0]);
            $order->updated_at_p = jdate('Y/m/d H:i' , $dates[$key][1]);
            if($dates[$key][2])
                $order->deleted_at_p = jdate('Y/m/d H:i' , $dates[$key][2]);
            else
                $order->deleted_at_p = null;
            $orders[$key] = $order;
        }
        return [$orders , $users];
    }

    public function fromTelegram($id ,$pass)
    {
        $user = User::findOrFail($id);
        return $user->password;
        if($user){
            auth()->login($user);
            return redirect()->route('listOrders');
        }
        return abort(404);
    }
}
