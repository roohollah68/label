<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class NewOrderController extends Controller
{
    public function showForm()
    {
        if (auth()->user()->role == 'admin') {
            $admin = true;
        } else {
            $admin = false;
        }
        return view('addForm',['admin'=>$admin]);
    }

    public function insertOrder(Request $request)
    {
        request()->validate([
            'receipt'  => 'mimes:jpeg,jpg,png,bmp|max:2048',
        ]);
        if($request->file("receipt")){
            $request->receipt = $request->file("receipt")->store("",'public');
        }
        auth()->user()->orders()->create([
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
