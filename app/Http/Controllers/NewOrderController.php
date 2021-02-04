<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class NewOrderController extends Controller
{
    public function showForm()
    {
        return view('addForm');
    }

    public function insertOrder(Request $request)
    {
        if (auth()->user()->orders()->create($request->all()))
            return ['سفارش با موفقیت ثبت شد', 'success'];
       return ['مشکلی به وجود آمده است', 'error'];
    }
}
