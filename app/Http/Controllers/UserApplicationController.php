<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests\ApplicationRequest;

class UserApplicationController extends Controller
{
    public function overtime_index(){
        $title = "残業申請";
        return view('user.overtime' , [
            'title' => $title,
        ]);
    }

    public function overtime_application(ApplicationRequest $request){

        $starttime = date('Y-m-d H:i:s' , strtotime($request->date.''.$request->start_h.':'.$request->start_m.':00') );
        $endtime = date('Y-m-d H:i:s' , strtotime($request->date.''.$request->end_h.':'.$request->end_m.':00'));
        $result = DB::table('overtimes')->updateOrInsert(
            [ 'user_id'=> \Auth::user()->id , 'date' => $request->date,],
            ['starttime' => $starttime,
            'endtime' => $endtime,
            'status' => 1,
            'comment' => $request->comment,
            'created_at' => now(),
            'updated_at' => now(),]
        );
        if($result){
            session()->flash('flash_message' , '残業申請をしました');
        }else{
            session()->flash('flash_message' , '申請中にエラーが発生しました。');
        }
        return redirect('/overtime');
    }
}
