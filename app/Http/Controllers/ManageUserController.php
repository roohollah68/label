<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageUserController extends Controller
{
    public function showHome()
    {
        if (auth()->user()->role == 'admin') {
            $admin = true;
        }else{
            $admin = false;
        }
        return view('orders');
    }

    public function show()
    {
        if (auth()->user()->role == 'admin') {
            $admin = true;
        }else{
            $admin = false;
        }
        return view('manage-users');
    }
}
