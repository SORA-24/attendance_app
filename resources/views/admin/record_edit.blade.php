@extends(' layouts.default')

@section('title' , $title)

@include('head.head')

@section('content')
<h1 class='page-title'>{{ $title }}</h1>
<!-- エラーメッセージ出力 -->
@foreach($errors->all() as $error)
    <p class="error">{{ $error }}</p>
@endforeach
<main>
    <div class="table_box">
        <form action="/admin/user_edit" method='post'>
            {{ csrf_field() }}
            <table>
                <tr>
                @php
                    $ths = ['','勤務','ログイン状況','出勤時間','退勤時間','休憩時間','勤務時間','残業時間'];
                @endphp
                            @foreach($ths as $th)
                                <th>{{ $th }}</th>
                            @endforeach
                </tr>
                <tr {{-- 曜日の表示 --}}
                    @if(date("w", strtotime("${d}")) == 0)
                        class = "red @if( date('Y-m-d') == date('Y-m-d', strtotime("${d}"))) today_red @endif "
                    @elseif(date("w", strtotime("${d}")) == 6)
                        class = "blue @if( date('Y-m-d') == date('Y-m-d', strtotime("${d}"))) today_red @endif "
                    @else
                        class = " @if( date('Y-m-d') == date('Y-m-d', strtotime("${d}"))) today_red @endif "
                    @endif
                    >
                        <td>
                        <!-- 日にちと曜日を表示 -->
                            {{ $d }}日(@php $week = array( "日", "月", "火", "水", "木", "金", "土" );
                            echo $week[date("w", strtotime("${d}"))]; @endphp)
                        </td>
                        <td><!-- 2行目　勤務 -->
                        <select name="work_status_id">
                            <option value="1">平日勤務</option>
                            <option value="2">休日出勤</option>
                            <option value="3">公休日</option>
                            <option value="5">有給休暇</option>
                        </select>
                        </td>
                        <td>
                            <!-- ログイン状況 -->
                            @isset($record->go_work)
                                @isset($record->leave_work)
                                    退勤
                                @endisset
                                @empty($record->leave_work)
                                    出勤中
                                @endempty 
                            @endisset
                        </td>
                            <!-- 出勤時間 -->
                        <td>
                            @component('components.select_datetime')
                                @isset($record->go_work)
                                    @slot('time' , $record->go_work)
                                @endisset
                                @empty($record->go_work)
                                    @slot('time' , '0:0:0')
                                @endempty
                                    @slot('name' , 'g')
                            @endcomponent
                        </td>
                        <td><!-- 出勤時間 -->
                            @component('components.select_datetime')
                                @isset($record->leave_work)
                                    @slot('time' , $record->leave_work)
                                @endisset
                                @empty($record->leave_work)
                                    @slot('time' , '0:0:0')
                                @endempty
                                    @slot('name' , 'l')
                            @endcomponent
                        </td>
                        <td>
                            <select name="break_time">
                            <!-- 休憩時間 -->
                            @if($record->break_time > 0)
                            <option value="{{$record->break_time}}">
                                @component('components.time')
                                    @slot('time' , $record->break_time)
                                @endcomponent
                            </option>
                            @endisset
                            @for($i = 0 ; $i <= 60*60*3 ; $i += 60*30 )
                                <option value="{{$i}}">
                                    @component('components.time')
                                    @slot('time' , $i)
                                    @endcomponent
                                </option>
                            @endfor
                            </select>
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
                </tr>
            </table>
            <input type="hidden" name="date" value="{{$d}}">
            <input type="hidden" name="user_id" value="{{$user_id}}">
            <input type="submit" value="更新する">
        </form>
    </div>
</main>
@php $date = date('Y-m' , strtotime($d) ) @endphp 
<a class="btn btn-original" href="/admin/user_id{{ $record->user_id }}/{{ $date }}">戻る</a>

@endsection
