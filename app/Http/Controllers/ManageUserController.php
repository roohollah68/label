<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManageUserController extends Controller
{

    public function home()
    {
        return redirect()->route('listOrders');
    }

    public function show()
    {
        if (auth()->user()->role != 'admin')
            abort(404);
        $users = User::all();
        $admin = true;
        return view('manage-users', ['admin' => $admin, 'users' => $users]);
    }

    public function delete($id)
    {
        if (auth()->user()->role != 'admin')
            abort(404);
        User::where('id', $id)->where('role', 'user')->where('verified', false)->delete();
        return redirect()->route('manageUsers');
    }

    public function confirm($id)
    {
        if (auth()->user()->role != 'admin')
            abort(404);
        User::find($id)->update(['verified' => true]);
        return redirect()->route('manageUsers');
    }

    public function suspend($id)
    {
        if (auth()->user()->role != 'admin')
            abort(404);
        User::where('id', $id)->where('role', 'user')->update(['verified' => false]);
        return redirect()->route('manageUsers');
    }

    public function edit($id)
    {
        if (auth()->user()->role != 'admin')
            abort(404);
        $user = User::find( $id);
        return view('edit-user',['admin' => true,'user'=>$user]);
    }

    public function update($id, Request $request)
    {
        if (auth()->user()->role != 'admin')
            abort(404);
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|min:5',
            'phone' => 'required|digits:11',
            'website' => 'required',
        ]);

        User::find($id)->update([
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'website' => $request->website,
        ]);

        if($request->password) {
            $request->validate([
                'password' => 'required|string|min:8',
            ]);
            User::find($id)->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('manageUsers');
    }
}
