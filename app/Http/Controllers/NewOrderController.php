<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class NewOrderController extends Controller
{
    public function showForm(Request $request)
    {
        if (auth()->user()->role == 'admin') {
            $admin = true;
        } else {
            $admin = false;
        }
        return view('addForm', ['admin' => $admin, 'req' => $request->all()]);
    }

    public function insertOrder(Request $request)
    {
        request()->validate([
            'receipt' => 'mimes:jpeg,jpg,png,bmp|max:2048',
        ]);
        if ($request->file("receipt")) {
            $request->receipt = $request->file("receipt")->store("", 'public');
        } elseif ($request->file) {
            $request->receipt = $request->file;
        }
        $order = auth()->user()->orders()->create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'orders' => $request->orders,
            'desc' => $request->desc,
            'receipt' => $request->receipt,
        ]);
        TelegramController::sendOrderToTelegram($order);
        TelegramController::sendOrderToTelegramAdmins($order);
        return redirect()->route('listOrders');
    }

    public function fromTelegram($id, $pass)
    {
        $user = User::findOrFail($id);
        if ($user->password == $pass) {
            auth()->login($user);
            return redirect()->route('newOrder');
        }
        return abort(404);
    }

    public function fromTelegramWithPhoto($id, $pass, $file_id)
    {
        $user = User::findOrFail($id);
        if ($user->password == $pass) {
            auth()->login($user);
            $order = $user->orders->where('receipt', $file_id . '.jpg')->first();
            if ($order)
                return redirect("edit_order/{$order->id}");
            elseif (TelegramController::savePhoto($file_id))
                return redirect("add_order?file=$file_id");
        }
        return abort(404);
    }
}
