<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Jobs\SendEmailNewUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;


class AuthLoginController extends Controller
{
    public function register() {
        return view("frontend.pages.registerv2");
    }

    public function registerCreator() {
        return view("frontend.pages.register-creator");
    }

    public function registerNewMember(Request $request) {
        $validator = \Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'phone' => ['required', 'regex:/(01)[0-9]{9}/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => 'required_with:password|same:password'
        ]);

        if($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        dispatch(new SendEmailNewUser($request->email));

        return redirect(url("/"));
    }

    public function login() {
        return view("frontend.pages.login");
    }

    public function loginPost(LoginRequest $request) {
        $request->authenticate();
        $request->session()->regenerate();

        if(Auth::check()) {
            return redirect()->intended("/profile");
            // return redirect()->intended(RouteServiceProvider::USER);
        }
    }


    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
