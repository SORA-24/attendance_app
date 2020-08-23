<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Record;
class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
// トップページ
    public function index(){
        if(\Auth::user()->user_type == 1){
            return redirect('/top');
        }
        $title = '管理者用ページ';
        $messages = DB::table('messages')
                    ->join('users', 'messages.send_at_id','=','users.id')
                    ->get();
        $record = \App\Record::whereDate('date', date('Y-m-d'))
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
        return view('admin.index',[
            'title' => $title,
            'messages' => $messages, 
            'record' => $record,
            'leave_work' => $leave_work ,
        ]);
        
    }
    // 当日の勤務状況確認ページ
    public function day_index($year ,$month ,$day , Request $request){
        if(\Auth::user()->user_type == 1){
            return redirect('/top');
        }
        $selectday = "${year}-{$month}-${day}";
        $title = '勤務状況';
            // ユーザ情報を取得
        $query = User::query();
        $query ->select('*', 'users.id as user_id' ,'records.user_id as record_id');
        $query->leftJoin('records', function ($join) use ($selectday) {
            $join->on('users.id', '=','records.user_id')
            ->Where('records.date','=', $selectday );
        });
        $query->leftJoin('work_statuses' , 'records.work_status_id','=','work_statuses.id');
        // inputで入力した文字を受け取る
        $search = $request->input('keyword_name');
        // ユーザ名を入力していなければ、すべてを取得する
        if($request->has('keyword_name') && $search != ''){
            $query -> where('users.name' , 'like' , '%'.$search.'%')->get();
        }
        $data = $query->paginate(10);
        return view('admin.day' , [
            'title' => $title ,
            'data' => $data,
            'year'=> $year,
            'month'=> $month,
            'day'=> $day,
        ]);

    }
    // ユーザ一覧ページ
    public function user_index(Request $request){
        if(\Auth::user()->user_type == 1){
            return redirect('/top');
        }
            $query = User::query(); 
        // inputで入力した文字を受け取る
            $search = $request->input('keyword_name');
        // ユーザ名を入力していなければ、すべてを取得する
        if($request->has('keyword_name') && $search != ''){
            $query -> where('name' , 'like' , '%'.$search.'%')
                ->get();
        }
            $data = $query->paginate(10);
        $records = DB::table('records')
                ->whereYear('date' , '2020')
                ->whereMonth('date' , '8')
                ->where('work_status_id' , 4)
                ->get();
        $overtimes = DB::table('overtimes')
                ->whereYear('date' , '2020')
                ->whereMonth('date' , '8')
                ->where('status' , '2')
                ->get();
                // dd($overtimes);
        $title = "ユーザ一覧";
        return view('admin.user' , [
            'title' => $title, 
            'data'=> $data,
            'records' => $records,
            'overtimes' => $overtimes,
        ]);
    }
    // 申請確認ページ
    public function application_index(){
        if(\Auth::user()->user_type == 1){
            return redirect('/top');
        }
        $title = "申請一覧" ;
        $holidays = DB::table('users')
            ->leftjoin('records' , 'records.user_id' ,"=" , 'users.id')
            ->where('work_status_id' , '3')
            ->get();
        $overtimes = DB::table('overtimes')
            ->select('*' , 'overtimes.id as overtime_id' , 'users.id as user_id')
            ->leftjoin('users' , 'overtimes.user_id' ,"=" , 'users.id')
            ->where('overtimes.status' , '1')
            ->get();
            return view('admin.application' , [
                'title' => $title,
                'holidays' => $holidays,
                'overtimes' => $overtimes,
            ]);
    }
    // 勤務員の詳細確認ページ
    public function work_index($user_id,$year,$month){
        $title = "勤務状況確認ページ（管理者）";
        $records = \App\Record::whereMonth('date' , $month)
                    ->select('*' , 'records.id as record_id', 'work_statuses.id as work_status_id' )
                    ->leftjoin('work_statuses' ,'records.work_status_id' , 'work_statuses.id')
                    ->where('user_id' , $user_id )
                    ->get();
        $user = \App\User::where('id' , $user_id)
                ->first();
        $overtimes = DB::table('overtimes')
                ->whereMonth('date' ,$month)
                ->where('user_id' , $user_id )
                ->get();
        $edit_status = true ;
        return view('user.work',[
            'title' => $title,
            'records' => $records ,
            'year' => $year,
            'month' => $month,
            'user' => $user,
            'overtimes' => $overtimes,
            'edit_status' => $edit_status ,
        ]);       
    }

    // 社員登録ページ
    public function user_register_index(){
        $title = '社員登録ページ';
        return view('admin.register',[
            'title' => $title,
        ]);
    }
    

    
}