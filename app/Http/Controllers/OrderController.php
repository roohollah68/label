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

    public function editForm($id)
    {
        $order = Order::find($id);
        if (!$order)
            abort(404);
        return view('editForm')->with(['order' => $order]);
    }

    public function insertOrder(Request $request)
    {
        if (Order::create($request->all()))
            return ['سفارش با موفقیت ثبت شد', 'success'];
        return ['مشکلی به وجود آمده است', 'error'];
    }

    public function editOrder($id , Request $request)
    {
        Order::find($id)->update($request->all());
        return redirect()->route('listOrders');
    }

    public function showHome()
    {
        return view('home');
    }

    public function showOrders()
    {
        return view('orders');
    }

    public function getOrders(Request $request)
    {
        if ($request['deleted'] === "true")
            return Order::onlyTrashed()->get();
        return Order::all();
    }

    public function deleteOrder($id, Request $request)
    {
        if ($request['deleted'] === "true") {
            if (Order::withTrashed()->find($id)->forceDelete())
                return 'با موفقیت حذف شد';
            return 'مشکلی پیش آمده است';
        } else {
            if (Order::find($id)->delete())
                return 'با موفقیت حذف شد';
            return 'مشکلی پیش آمده است';
        }
    }

    public function deleteOrders(Request $request)
    {
        if ($request['deleted'] === "true") {
            foreach ($request['ids'] as $id)
                Order::withTrashed()->find($id)->forceDelete();
        } else {
            foreach ($request['ids'] as $id)
                Order::find($id)->delete();
        }
    }

    public function restoreOrder($id)
    {
        if (Order::onlyTrashed()->find($id)->restore())
            return 'با موفقیت بازگردانی شد';
        return 'مشکلی پیش آمده است';
    }
}
