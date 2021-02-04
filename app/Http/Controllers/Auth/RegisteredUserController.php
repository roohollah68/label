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
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

//        Auth::login($user = User::create([
//            'name' => $request->name,
//            'username' => $request->username,
//            'password' => Hash::make($request->password),
//        ]));

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'website' => $request->website,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->route('newUserMessage');
    }

    public function newUserMessage()
    {
        return view('auth.new-user-message');
    }
}
