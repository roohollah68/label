<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class EditOrderController extends Controller
{
    public function editForm($id)
    {
        if (auth()->user()->role == 'admin') {
            $order = Order::findOrFail($id);
            return view('editForm')->with(['order' => $order]);
        }
        $order = auth()->user()->orders()->findOrFail($id);
        return view('editForm')->with(['order' => $order]);
    }

    public function editOrder($id, Request $request)
    {
        if (auth()->user()->role == 'admin') {
            Order::findOrFail($id)->update($request->all());
            return redirect()->route('listOrders');
        }
        auth()->user()->orders()->findOrFail($id)->update($request->all());
        return redirect()->route('listOrders');
    }

}
