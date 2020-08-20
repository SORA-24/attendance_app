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
            // $query -> select('*' , 'users.id as user_id' , 'records.id as records_id' ,);
            // $query->leftjoin('records' , function($join){
            //     $join->on('users.id' ,'=', 'records.user_id')
            //         ->where('records.work_status_id' , '5')
            //         ->groupBy('user_id');
            // });
        // inputで入力した文字を受け取る
            $search = $request->input('keyword_name');
        // ユーザ名を入力していなければ、すべてを取得する
        if($request->has('keyword_name') && $search != ''){
            $query -> where('name' , 'like' , '%'.$search.'%')
                ->get();
        }
        $data = $query->paginate(10);
        
        $title = "ユーザ一覧";
        return view('admin.user' , [
            'title' => $title, 
            'data'=> $data,
        ]);
    }
    // 申請確認ページ
    public function application_index(){
        if(\Auth::user()->user_type == 1){
            return redirect('/top');
        }
        $title = "休日申請一覧" ;
        $data = DB::table('users')
            ->leftjoin('records' , 'records.user_id' ,"=" , 'users.id')
            ->where('work_status_id' , '4')
            ->get();
            return view('admin.application' , [
                'title' => $title,
                'data' => $data,
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
        return view('user.work',[
            'title' => $title,
            'records' => $records ,
            'year' => $year,
            'month' => $month,
            'user' => $user,
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