<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * ログインフォームの表示
     * @return View
     */
    public function showLogin()
    {
        return view('login.login_form');
    }

    /**
     * ログイン処理
     * @param App\Http\Requests\LoginFormRequest $request
     */
    public function login(LoginFormRequest $request)
    {
        $credentials = $request->only('personal_id', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('home')->with('login_success', 'ログインは成功しました！');
        }

        return back()->withErrors([
            'login_error' => 'IDもしくはパスワードが間違っています。',
        ]);
    }
}
