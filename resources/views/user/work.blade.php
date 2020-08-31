@extends(' layouts.default')

@section('title' , $title)

@include('head.head')

@section('content')
@php 
 // 出勤日数  
$num_attedance = 0 ;
 // 残業時間  
$sum_overtime = 0;
@endphp 
<h1 class='page-title'>{{ $title }}</h1>
<!-- エラーメッセージ出力 -->
@foreach($errors->all() as $error)
    <p class="error">{{ $error }}</p>
@endforeach

<h2 class='main-title'>{{ $year.'年'.$month }}月勤務状況</h2>
<h5>{{ $user->name }}さんの勤務状況</h5>
<div class="month">
@if( Auth::user()->user_type === 2 && isset($edit_status))
    <a class="btn btn-outline-info" href="/admin/user_id{{$user->id}}/{{ $year}}-{{ $month -1 }}">前月へ</a>
    <a class="btn btn-outline-info" href="/admin/user_id{{$user->id}}/{{ $year}}-{{ $month +1 }}">次月へ</a>
@else
    <a class="btn btn-original" href="/work/{{ $year }}-{{ $month -1 }}">前月へ</a>
    <a class="btn btn-original" href="/work/{{ $year }}-{{ $month +1 }}">次月へ</a>
@endif
</div>
<main>
    <div class="table_box">
        <table>
            <tr>
            @php
                $ths = ['','勤務','出勤時間','退勤時間','休憩時間','勤務時間','申請残業時間',];
            @endphp
            @if( Auth::user()->user_type === 2 && isset($edit_status))
                    @php array_push($ths , '編集') @endphp
                @else
                    @php array_push($ths , 'コメント') @endphp
            @endif
                        @foreach($ths as $th)
                            <th>{{ $th }}</th>
                        @endforeach
            </tr>
            @for($i = 1 ; $i <= 31 ; $i++)
                <tr {{-- 曜日の表示 --}}
                @if(date("w", strtotime("${year}-${month}-${i}")) == 0)
                    class = "red @if( date('Y-m-d') == date('Y-m-d', strtotime("${year}-${month}-${i}"))) today_red @endif "
                @elseif(date("w", strtotime("${year}-${month}-${i}")) == 6)
                    class = "blue @if( date('Y-m-d') == date('Y-m-d', strtotime("${year}-${month}-${i}"))) today_red @endif "
                @else
                    class = " @if( date('Y-m-d') == date('Y-m-d', strtotime("${year}-${month}-${i}"))) today_red @endif "
                @endif
                >
                    <td>
                    <!-- 日にちと曜日を表示 -->
                        {{ $i }}日(@php $week = array( "日", "月", "火", "水", "木", "金", "土" );
                        echo $week[date("w", strtotime("${year}-${month}-${i}"))]; @endphp)
                    </td>
                    @forelse($records as $record)
                        {{-- 該当の日にちにデータがあれば、表示する --}}
                        @isset($record->date)
                            @if( substr($record->date ,-2 ,2 ) == str_pad($i ,2, 0, STR_PAD_LEFT))
                                <td>
                                    <!-- 勤務 -->
                                @isset($record->work_status)
                                    {{ $record->work_status}}
                                @endisset
                                </td>
                                <!-- 出勤時間 -->
                                <td>
                                @isset($record->go_work)
                                    {{ date("G:i:s" , strtotime("$record->go_work")) }}</td>
                                    @php $num_attedance ++ ; @endphp
                                @endisset
                                <!-- 退勤時間 -->
                                <td>
                                    @isset($record->leave_work)
                                    {{ date("G:i:s",strtotime("$record->leave_work")) }}
                                    @endisset
                                </td>
                                <td>
                                    <!-- 休憩時間 -->
                                    @isset($record->break_time)
                                    @component('components.time')
                                        @slot('time' , $record->break_time)
                                    @endcomponent
                                    @endisset
                                </td>
                                <td>
                                    <!-- 勤務時間 => $working-->
                                    @isset($record->leave_work)
                                    @php 
                                    $working = strtotime($record->leave_work) - strtotime($record->go_work)- $record->break_time 
                                    @endphp
                                        @component('components.time')
                                            @slot('time' , $working)
                                        @endcomponent
                                    @endisset
                                </td>
                                <td>
                                    <!-- 申請残業時間 -->
                                    @foreach($overtimes as $val)
                                        @if( substr($val->date ,-2 ,2 ) == str_pad($i ,2, 0, STR_PAD_LEFT))
                                            @php 
                                            $overtime = strtotime("$val->endtime") - strtotime("$val->starttime");
                                            $sum_overtime += $overtime;
                                            @endphp 
                                            @component('components.time')
                                                @slot('time' , $overtime)
                                            @endcomponent
                                        @endif
                                    @endforeach
                                </td>
                                @include('components.edit_or_comment')
                                @break
                            @endif
                        @endisset
                        <!-- ループの最後でも一致するものがなければ、空のtdをつくります -->
                            @if( $loop->last && substr($record->date,-2 ,2 ) !==  str_pad($i , 2, 0 ,STR_PAD_LEFT))
                                <td>
                                    @if(date("w", strtotime("${year}-${month}-${i}")) == 6 || (date("w", strtotime("${year}-${month}-${i}")) == 0))
                                    公休日
                                    @else
                                    通常
                                    @endif
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>   <!-- 申請残業時間 -->
                                    @foreach($overtimes as $val)
                                        @if( substr($val->date ,-2 ,2 ) == str_pad($i ,2, 0, STR_PAD_LEFT))
                                            @php 
                                            $overtime = strtotime("$val->endtime") - strtotime("$val->starttime");
                                            $sum_overtime += $overtime;
                                            @endphp 
                                            @component('components.time')
                                                @slot('time' , $overtime)
                                            @endcomponent
                                        @endif
                                    @endforeach
                                </td>
                               　<td></td>
                                @break
                            @endif
                    @empty{{--そもそも一つもデータが無かった場合--}}
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                        <!-- 申請残業時間 -->
                        @foreach($overtimes as $val)
                            @if( substr($val->date ,-2 ,2 ) == str_pad($i ,2, 0, STR_PAD_LEFT))
                                @php 
                                $overtime = strtotime("$val->endtime") - strtotime("$val->starttime");
                                $sum_overtime += $overtime;
                                @endphp 
                                @component('components.time')
                                    @slot('time' , $overtime)
                                @endcomponent
                            @endif
                        @endforeach</td>
                        <td>
                        @include('components.edit_or_comment')
                        </td>
                    @endforelse
                </tr>
            @endfor
        </table>
    </div>
    <div class="status">
        <p>当月勤務状況　出勤数{{$num_attedance}}日
            残業時間：
                @component('components.time')
                    @slot('time' , $sum_overtime)
                @endcomponent        
        </p>
    </div>
</main>
<a class="btn btn-original" href="/top">戻る</a>
@endsection

