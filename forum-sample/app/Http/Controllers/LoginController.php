<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function authenticate(Request $request) {
        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::HOME);
        } else {
            return back()->withErrors([
                'message' => 'メールアドレスまたはパスワードが正しくありません'
            ]);
        }
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
