<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $req = $request->all();
        if (!isset($req['name']))
            $req = [
                "name" => "",
                "phone" => "",
                "telegram_id" => ""
            ];

        return view('auth.register', ['req' => $req]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|min:5|unique:users',
            'phone' => 'required|digits:11|unique:users',
            'website' => 'required',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'website' => $request->website,
            'telegram_id'=>$request->telegram_id,
            'password' => Hash::make($request->password),
        ]);
        Auth::login($user);

        event(new Registered($user));

//        return redirect()->route('newUserMessage');
        return redirect()->route('listOrders');
    }

    public function newUserMessage()
    {
        return view('auth.new-user-message');
    }
}
