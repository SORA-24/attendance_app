<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/top';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    use AuthenticatesUsers {
        // logout というメソッドを、doLogoutというメソッド名に変更して継承する
        logout as doLogout;
    }
    public function logout(Request $request){
        // 1. 元々のログアウト処理を実行する
        $this->doLogout($request);
        // 2. リダイレクト先を独自に設定する。
        return redirect('/login'); 
    }
    public function username()
    {
      return 'id';
    }

    public function is_admin(){
        if( \Auth::user()->user_type === 2){
            return true;
        }
        return false;
    }
}
