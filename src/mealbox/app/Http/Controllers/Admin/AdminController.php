<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Adminユーザーのログインフォームの表示
     * @return View
     */
    function showLogin()
    {
        return view('admin.admin_login');
    }

    /**
     * Adminユーザーのログイン処理
     * @param Illuminate\Http\Request
     */
    function login(Request $request)
    {
        // 内容の確認
        $user_id = $request->input('user_id');
        $password = $request->input('password');
        if ($user_id === "laravel" && $password == "laravel") {
            // ログインの成功
            $request->session()->put("admin_auth", true);
            return redirect()->route("admin.top");
        }

        // ログイン失敗
        return back()->withErrors([
            'danger' => '管理者IDもしくはパスワードが間違っています。',
        ]);
    }

    /**
     * Adminユーザーをアプリケーションからログアウトさせる
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    function logout(Request $request)
    {
        $request->session()->forget("admin_auth");

        return redirect()->route('admin.showLogin')->with('danger', 'ログアウトしました！');
    }

    /**
     * 管理者トップページの表示
     * @return View
     */
    function show()
    {
        return view("admin.admin_top");
    }

    /**
     * 管理側ユーザー一覧表示
     * @return View
     */
    function showUserList()
    {
        $user_list = User::orderBy("id", "desc")->paginate(10);
        return view("admin.user_list", ["user_list" => $user_list]);
    }

    /**
     * 管理側ユーザー詳細表示
     * @param $id
     * @return View
     */
    function showDetail($id)
    {
        $user = User::find($id);
        return view("admin.user_detail", ["user" => $user]);
    }
}   
