<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DeleteOrderController extends Controller
{
    public function deleteOrder($id, Request $request)
    {
        if (auth()->user()->role == 'admin')
            $order = Order::withTrashed()->findOrFail($id);
        else
            $order = auth()->user()->orders()->withTrashed()->findOrFail($id);
        if ($order->trashed()) {
            if ($order->forceDelete())
                return 'با موفقیت حذف شد';
        }else
            if ($order->delete())
                return 'با موفقیت حذف شد';

        return 'مشکلی پیش آمده است';
    }

    public function deleteOrders(Request $request)
    {
        foreach ($request['ids'] as $id) {
            if (auth()->user()->role == 'admin')
                $order = Order::withTrashed()->findOrFail($id);
            else
                $order = auth()->user()->orders()->withTrashed()->findOrFail($id);
            $order->trashed() ?
                $order->forceDelete()
                :
                $order->delete();
        }
    }

    public function restoreOrder($id)
    {
        if (auth()->user()->role == 'admin')
            $order = Order::withTrashed()->findOrFail($id);
        else
            $order = auth()->user()->orders()->withTrashed()->findOrFail($id);
        if ($order->restore())
            return 'با موفقیت بازگردانی شد';
        return 'مشکلی پیش آمده است';
    }
}
