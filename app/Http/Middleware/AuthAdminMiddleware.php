<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

        // もしadminユーザがログインしたらadmin_topにリダイレクト
        public function __construct(){ 
       
    }

    // ①こいつを呼び出す方法
    //  Route('/' , Ct@id)->middleware(AuthAdminMiddleware::class);
    // ②index内で$requestの中身を出力する方法->
    // middlewareで
    //  $request->merge(['data'=> 入れたい配列など])
    // controllerで
    //  [$data=>$request->data];
}
