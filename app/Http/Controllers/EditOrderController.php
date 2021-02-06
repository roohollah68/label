<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class EditOrderController extends Controller
{
    public function editForm($id)
    {
        if (auth()->user()->role == 'admin') {
            $admin = true;
            $order = Order::findOrFail($id);
        }else {
            $admin = false;
            $order = auth()->user()->orders()->findOrFail($id);
        }
        return view('editForm')->with(['order' => $order,'admin' => $admin]);
    }

    public function editOrder($id, Request $request)
    {
        if (auth()->user()->role == 'admin') {
            $order = Order::findOrFail($id);
        }else{
            $order =auth()->user()->orders()->findOrFail($id);
        }

        request()->validate([
            'receipt'  => 'mimes:jpeg,jpg,png,bmp|max:2048',
        ]);

        if($request->file("receipt")){
            $request->receipt = $request->file("receipt")->store("",'public');
        }else{
            $request->receipt = $order->receipt;
        }

        $order->update([
            'name'=> $request->name,
            'phone'=> $request->phone,
            'address'=> $request->address,
            'zip_code'=> $request->zip_code,
            'orders'=> $request->orders,
            'desc'=> $request->desc,
            'receipt'=> $request->receipt,
        ]);
        return redirect()->route('listOrders');
    }

}
