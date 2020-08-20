<?php

//修正
namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth; //追記

class LoginController extends Controller
{

    // use AuthenticatesUsers;
    use AuthenticatesUsers {
        logout as doLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin_top'; //リダイレクト先（未作成）

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login'); //管理者ログインページのテンプレート（未作成）
    }

    protected function guard()
    {
        return Auth::guard('admin'); //管理者認証のguardを指定
    }

    public function logout(Request $request)
    {
        $this->guard('admin')->logout();
       // $request->session()->invalidate(); これが全部のSessionを消してしまう
        return redirect('/admin/login');
    }

    public function username()
    {
        return 'id';
    }
}
