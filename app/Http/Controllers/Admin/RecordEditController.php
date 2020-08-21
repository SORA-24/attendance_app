<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Record;
use App\User;
use DB;

class RecordEditController extends Controller
{
    public function edit_index(Request $request){
        // $user_id $d が渡ってきています
        $title = $request->d.'編集ページ';
        $query = User::query();
        $query ->select('*', 'users.id as user_id' ,'records.user_id as record_id');
        $query->leftJoin('records', function ($join) use ($request) {
            $join->on('users.id', '=','records.user_id')
            ->Where('records.date','=', $request->d );
        });
        $query->leftJoin('work_statuses' , 'records.work_status_id','=','work_statuses.id');
        $query -> where('users.id' ,$request->user_id); 
        $record = $query->first();
        $overtime = DB::table('overtimes')
                    ->WhereDate('date', $request->d )
                    ->where('user_id' , $request->user_id )
                    ->first();
        return view('admin.record_edit',[
                'title' => $title,
                'record' => $record,
                'd' => $request->d,
                'user_id' => $request->user_id,
                'overtime' =>$overtime,
            ]);
    }
    public function edit_record(Request $request){
        $go_work = ($request->date.' '.$request->g_h.':'.$request->g_m.':'.$request->g_s );
        $leave_work = ($request->date.' '.$request->l_h.':'.$request->l_m.':'.$request->l_s );
        if($request->g_h+$request->g_m+$request->g_s <= 0 ){
            $go_work = null;
        }
        if($request->l_h+$request->l_m+$request->l_s <= 0 ){
            $leave_work= null;
        }
        if($request->break_time <= 0){
            $request->break_time = null;
        }
            DB::table('records')->updateOrInsert(
                ['user_id' => $request->user_id, 'date' => $request->date],
                ['work_status_id' => $request->work_status_id,
                'go_work'=> $go_work,
                'user_id' => $request->user_id,
                'leave_work' => $leave_work,
                'break_time' => $request->break_time,
                'date' => $request->date,
                'created_at' => now(),
                'updated_at' => now(),
                ]);
                session()->flash('flash_message',$request->date.'の勤務情報を更新しました。');       
        $y_m =  mb_substr($request->date , 0,7);
        return redirect('admin/user_id'.$request->user_id.'/'.$y_m);
    }
}

