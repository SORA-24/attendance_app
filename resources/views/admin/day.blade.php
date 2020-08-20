@extends('layouts.default')
@include('head.head')
@section('title' , $title)
@section('content')
<h1 class="page-title" >{{ $title }}</h1>
    @foreach($errors->all() as $error)
        <p class="error alert alert-danger" role="alert">{{ $error }}</p>
    @endforeach
<main >
    <div class="wrap">    
        <div class="search_box">
            <form action="/day/{{ $year}}-{{ $month }}-{{ $day }}">
                <input type="search" name="keyword_name" placeholder='氏名を入力してください' class='content-width'>
                <input type="submit" value="検索">
            </form>
        </div>
        <div class="table_box">
            <table>
        @php
            $ths = ['ID','氏名','勤務','ログイン状況','出勤時間','退勤時間','休憩時間','勤務時間','残業時間'];
        @endphp
                <tr>
                    @foreach($ths as $th)
                        <th>{{ $th }}</th>
                    @endforeach
                </tr>
                    @forelse($data as $value) 
                    <tr>
                        <td>{{ $value->user_id }}</td>
                        <td>{{ $value->name }}</td>
                        <td>
                            <!-- 勤務 -->
                            @isset($value->work_status)
                                {{ $value->work_status }}
                            @endisset
                        </td>
                        <td>
                            <!-- ログイン状況 -->
                            @isset($value->go_work)
                                @isset($value->leave)
                                退勤
                                @endisset
                                出勤中
                            @endisset
                        </td>
                        <td>
                            <!-- 出勤日時 -->
                            @isset($value->go_work)
                                {{ date("G:i:s",strtotime("$value->go_work")) }}
                            @endisset</td>
                        <td>
                            <!-- 退勤日時 -->
                            @isset($value->leave_work)
                                {{ date("G:i:s",strtotime("$value->leave_work")) }}
                            @endisset
                        </td>
                        <td>
                            <!-- 休憩時間 -->
                            @isset($value->break_time)
                            @component('components.time')
                                @slot('time' , $value->break_time)
                            @endcomponent
                            @endisset
                        </td>
                        <td>
                            <!-- 勤務時間 => $working-->
                            @isset($value->leave_work)
                            @php 
                            $working = strtotime($value->leave_work) - strtotime($value->go_work)- $value->break_time 
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
                        </td>
                    </tr>
                    @empty
                    @endforelse 
        </table>
        </div>
    </div>
    <p>{{ '本日は' . date('Y年n月j日') . 'です'}}</p>
    <h5 class="main-title">{{$year . '年' . $month .'月' }}</h5>

    <section class="calendar">
        <table>
        <div class="month">
            <a class="btn" href="/day/{{ $year}}-{{ $month -1 }}-{{$day}}">前月へ</a>
            <a class="btn" href="/day/{{ $year}}-{{ $month +1 }}-{{$day}}">次月へ</a>
        </div>
            <tr>
                @php 
                $day_weeks = ['日','月','火','水','木','金','土'] 
                @endphp
                @foreach($day_weeks as $day_week)
                    <th class="calendar__week">{{ $day_week }}</th>
                @endforeach
            </tr>
                    <tr>
            @for($i = 1 ; $i <= 31 ; $i++)
                @if($i === 1)
                @for($td = 0 ; $td < date('w', strtotime("${year}-${month}-${i}")) ; $td++)
                    <td></td>
                @endfor
                @endif
                @if(date('w', strtotime("${year}-${month}-${i}")) % 7 == 0 )
                <!-- 日曜日 -->
                    <tr>
                        <td class="red @if( date('Y-m-d') == date('Y-m-d', strtotime("${year}-${month}-${i}"))) today_red @endif">
                            <a class="calendar__submit" href="/day/{{$year}}-{{$month}}-{{$i}}">{{$i}}</a>
                        </td>
                @elseif(date('w', strtotime("${year}-${month}-${i}")) % 7 == 6 )
                <!-- 土曜日 -->
                        <td class="blue @if( date('Y-m-d') == date('Y-m-d', strtotime("${year}-${month}-${i}"))) today_red @endif ">
                            <a class="calendar__submit" href="/day/{{$year}}-{{$month}}-{{$i}}">{{$i}}</a>
                        </td>
                    </tr>
                @else
                <!-- 平日 -->
                    <td class="
                    @if( date('Y-m-d') == date('Y-m-d', strtotime("${year}-${month}-${i}"))) today_red @endif ">
                    <a class="calendar__submit" href="/day/{{$year}}-{{$month}}-{{$i}}">{{$i}}</a>
                    </td>
                @endif 
            @endfor
            </tr>
        </table>
    </section>    
</main>
<a class="btn" href="/admin_top">戻る</a>
@endsection
