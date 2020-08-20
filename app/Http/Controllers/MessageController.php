<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Quotation;

class MessageController extends Controller
{

    public function __construct()
    {
        // ログインのチェック
        $this->middleware('auth');
    }


    public function index(){
        if(\Auth::user()->user_type == 2){
            return redirect('/admin_top');
        }
        $title = 'トップページ';
        $messages = DB::table('messages')
                    ->join('users', 'messages.send_at_id','=','users.id')
                    ->get();
        $record = \App\Record::whereDay('created_at', date('d'))
                    ->where('user_id' , \Auth::user()->id )
                    ->first();
        if(isset($record)){
            if($record->break_time > 360 ){
                // 休憩時間が１時間以上であれば、８時間プラス休憩時間を表示する
                $date = strtotime($record->go_work) + (60*60*8) + $record->break_time;
            }else{
                // 休憩時間が１時間未満であれば、出勤の９時間後を表示する
                $date = strtotime($record->go_work) + (60*60*9);
            }
            $leave_work = date('H:i:s' ,$date);
        }else{
            $record =  "";
            $leave_work = "";
        }
        
        
        return view('top.index',[
            'title' => $title,
            'messages' => $messages, 
            'record' => $record,
            'leave_work' => $leave_work ,
        ]);

    }

    public function create(Request $request){
        
        $request->validate([
            'message' => 'required|max:1000',
        ]);
        $message = new \App\Message;
        $message->send_at_id = \Auth::user()->id; 
        $message->room_id = $request->room_id; 
        $message->message = $request->message; 
        $message->save();

        return redirect('/top');

    }
}
