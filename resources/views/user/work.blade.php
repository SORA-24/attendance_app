@extends(' layouts.default')

@section('title' , $title)

@include('head.head')

@section('content')
@php 
 // 出勤日数  
$num_attedance = 0 ;
 // 残業時間  
$overtime = 0;
@endphp 
<h1 class='page-title'>{{ $title }}</h1>
<!-- エラーメッセージ出力 -->
@foreach($errors->all() as $error)
    <p class="error">{{ $error }}</p>
@endforeach

<h2 class='main-title'>{{ $year.'年'.$month }}月勤務状況</h2>
<div class="month">
    <a class="btn btn-original" href="/work/{{ $year}}-{{ $month -1 }}">前月へ</a>
    <a class="btn btn-original" href="/work/{{ $year}}-{{ $month +1 }}">次月へ</a>
</div>
<main>
    <div class="table_box">
        <table>
            <tr>
            @php
                $ths = ['','勤務','出勤時間','退勤時間','休憩時間','勤務時間','残業時間',];
            @endphp
            @if( Auth::user()->user_type === 2 )
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
                                @php 
                                    $num_attedance ++ ;
                                @endphp
                                <td>
                                @isset($record->go_work)
                                {{ date("G:i:s" , strtotime("$record->go_work")) }}</td>
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
                                    <!-- 残業時間 -->
                                    @isset($working)
                                        @component('components.time')
                                            @slot('time' , $working - 60*60*8 )
                                        @endcomponent
                                    @endisset
                                    @php $working = null @endphp
                                </td>
                                @include('components.edit_or_comment')
                                @break
                            @endif
                        @endisset
                        <!-- ループの最後でも一致するものがなければ、空のtdをつくります -->
                            @if( $loop->last && substr($record->date,-2 ,2 ) !==  str_pad($i , 2, 0 ,STR_PAD_LEFT))
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                @include('components.edit_or_comment')
                                @break
                            @endif
                    @empty{{--そもそも一つもデータが無かった場合--}}
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endforelse
                </tr>
            @endfor
        </table>
    </div>
    <div class="status">
        <p>当月勤務状況　出勤数{{$num_attedance}}日　残業時間：{{floor($overtime / (60 * 60 )) ."時間". gmdate("i分" , $overtime)}}</p>
    </div>
</main>
<a class="btn btn-original" href="/top">戻る</a>
@endsection

