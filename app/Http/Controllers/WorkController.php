<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quotation;
use DB;

class WorkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // 打刻
    public function stamping(Request $request){    
        $day = date('d');
        $work_status_id = (date('w') == 0 || date('w') == 6) ? 2 : 1 ;
        if(isset($request->go_work)){
            // 出勤
            $today = \App\Record::whereDay('date', $day)
            ->where('user_id' , \Auth::user()->id )
            ->first();
            if(!isset($today->go_work)){
                $work = new \App\Record;
                $work->user_id = \Auth::user()->id; 
                $work->go_work = now();  
                $work->date = date('Y-m-d');
                $work->break_time = 0;
                $work->work_status_id = $work_status_id;  
                $work->save();
                session()->flash('flash_message', '出勤しました');
            }else{
                session()->flash('flash_message', '出勤済みです');
            }
        }elseif (isset($request->leave_work)){
            // 退勤
            $work = \App\Record::whereDay('date', $day)
            ->where('user_id' , \Auth::user()->id )
            ->update(['leave_work' => now()]);
            session()->flash('flash_message', '退勤しました');
        }elseif(isset($request->stop_work)){
            // 休憩開始
            $breaktime = DB::table('records')
                        ->where('user_id' , \Auth::user()->id ) 
                        ->whereDay('date', $day)
                        ->first();
            if(empty($breaktime->temporarily)){
            $breaktime = DB::table('records')
                ->where('user_id' , \Auth::user()->id ) 
                ->whereDay('date', $day)
                ->update(['temporarily' => time()]);
            session()->flash('flash_message','休憩を始めました');
            }
        }elseif(isset($request->restart_work)){
            // 休憩終了
            $temporarily = DB::table('records')                 
                        ->where('user_id' , \Auth::user()->id) 
                        ->whereDay('date', $day)
                        ->first();
            $oldbreaktime = $temporarily->break_time;
            if(isset( $temporarily->temporarily)){
            $breaktime = DB::table('records')         
                        ->where('user_id' , \Auth::user()->id) 
                        ->whereDay('date', $day)
                        ->update([
                            'break_time' => $oldbreaktime + (time() - $temporarily->temporarily) ,
                            'temporarily' => null
                        ]);
            session()->flash('flash_message','仕事を再開しました');
            }
        }
            return redirect('/top');
    }
    public function addcomment(Request $request){
        $comment = DB::table('records')
            ->whereDate('date' , date('Y-m-d'))
            ->where('user_id' , \Auth::user()->id)
            ->update(['comment' => $request->comment]);
        session()->flash('flash_message','コメントを記録しました');
        return redirect('/top');
    }
    
}
