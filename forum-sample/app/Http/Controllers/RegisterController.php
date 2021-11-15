<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\CodeKind;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index() {
        return view('auth.register');
    }

    public function signup(RegisterRequest $request) {
        // 画面から登録できるユーザは管理者権限を持たないようにする
        $role = CodeKind::where('name', 'ROLE')->first();
        $role_id = $role->code()
                        ->where('sort', 1)
                        ->first();
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $role_id->id,
            'password' => Hash::make($request->password),
        ]);

        return redirect(route('login'));
    }
}
