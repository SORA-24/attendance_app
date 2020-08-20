<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Record;
use DB;

class ApplicationController extends Controller
{
    // 休日申請登録
    public function paid_holidays_register(Request $request){
        $register = DB::table('records')
            ->where('id' , $request->record_id)
            ->update(['work_status_id' => 5] );
            session()->flash('flash_message', '休日申請を登録しました');
        return redirect('/application');
    }
}
