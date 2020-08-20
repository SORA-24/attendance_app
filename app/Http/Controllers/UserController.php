<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //勤務管理ページ
    public function work_index($year,$month){
        $title = "勤務状況確認ページ";
        $records = \App\Record::whereMonth('date' , $month)
                    ->leftjoin('work_statuses' ,'records.work_status_id' , '=', 'work_statuses.id' )
                    ->where('user_id' , \Auth::user()->id )
                    ->get();
        return view('user.work',[
            'title' => $title,
            'records' => $records ,
            'year' => $year,
            'month' => $month,
        ]);        
    }
    // 休日申請ページ
    public function holiday_index($year,$month){
        $title = '休日申請ページ';
        $records = \App\Record::whereMonth('date' , $month)
                    ->where('user_id' , \Auth::user()->id)
                    ->get();
        return view('user.holiday',[
            'title' => $title,
            'year' => $year,
            'month' => $month,
            '$records'=> $records,
        ]);
    }

    public function getAuth(Request $request){
        $title = 'ログインページ';
        return view('hello.auth',[
            'title'=> $title,
        ]);
    }
    public function postAuth(Request $request){
        $id = $request->id;
        $password = $request->password;
        if(Auth::attempt([
            'id'=>$id,
            'password'=>$password,
        ])){
            // ログイン成功
            return  redirect('/top');
        }else{
            redirect('/login');
        }
    }
    
}
