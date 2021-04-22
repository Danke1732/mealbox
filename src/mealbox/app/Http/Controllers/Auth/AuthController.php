<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\SignupFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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

            return redirect()->route('home')->with('success', 'ログインに成功しました！');
        }

        return back()->withErrors([
            'danger' => 'IDもしくはパスワードが間違っています。',
        ]);
    }

    /**
     * ユーザーをアプリケーションからログアウトさせる
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login.show')->with('danger', 'ログアウトしました！');
    }

    /**
     * 新規登録フォームの表示
     * @return View
     */
    public function showSignup()
    {
        return view('signup.signup_form');
    }

    /**
     * ユーザー登録処理
     * @param App\Http\Requests\SignupFormRequest $request
     */
    public function signup(SignupFormRequest $request)
    {
        \DB::beginTransaction();
        try {
            // DBインサート
            $user = new User([
            'personal_id' => $request->input('personal_id'),
            'password' => Hash::make($request->input('password')),
            'last_name' => $request->input('last_name'),
            'first_name' => $request->input('first_name')
            ]);
            
            // 保存
            $user->save();
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        // ログイン処理
        $credentials = $request->only('personal_id', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // リダイレクト
            return redirect()->route('home')->with('success', 'ユーザー登録が完了しました！');
        }
    }

    /**
	 * ログインユーザー詳細情報を表示
	 * @return View
	 */
	public function userDetail($id)
	{
		$user = User::findOrFail($id);
        $auth_user = Auth::user();
        if ($user->id === $auth_user->id) {
            return view('user_detail', ["user" => $user]);
        }

        return redirect()->route('home');
	}
}
