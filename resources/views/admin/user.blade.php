@extends('layouts.default')
@include('head.head')
@section('title' , $title)
@section('content')
<?php $ths = ["ID","氏名","月間残業時間","月間年休取得数","詳細ページ"]?> 
<h1>{{ $year."年".$month . "月".$title }}</h1>
    @foreach($errors->all() as $error)
        <p class="error">{{ $error }}</p>
    @endforeach

<main>
    <div>
        <div class="search_box">
            <form action="/user/{{$year}}-{{$month}}" >
                <input type="search" name="keyword_name" placeholder='氏名を入力してください' class='content-width'>
                <input type="submit" value="検索">
            </form>
        </div>
    </div>
    @component('components.monthbtn')
        @slot('year' , $year )
        @slot('month' , $month )
        @slot('page' , 'user')
    @endcomponent
    <div class="table_box">
        <table>
            <tr>
                @foreach($ths as $th)
                    <th>{{ $th }}</th>
                @endforeach
            </tr>
                @foreach($data as $val)
                    <tr>
                        <td>{{ $val -> id}}</td>
                        <td>{{ $val -> name}}</td>
                        <td>
                            @php $month_overtime = 0 @endphp 
                            @foreach($overtimes as $o)
                                @if($o->user_id == $val ->id)
                                    @php
                                        $day_overtime = strtotime($o->endtime) - strtotime($o->starttime);
                                        $month_overtime +=  $day_overtime ;
                                    @endphp
                                @endif
                            @endforeach
                                @component('components.time')
                                    @slot('time' , $month_overtime)
                                @endcomponent
                        </td>
                        <td>
                            @php $holiday_count = 0 @endphp 
                            @foreach($records as $record)
                                @if($record->user_id == $val->id)
                                    @php $holiday_count++ @endphp
                                @endif
                            @endforeach
                            {{ $holiday_count }} 
                        </td>
                        <td>
                            <a class="btn btn-outline-info" href="/admin/user_id{{$val->id}}/{{date('Y-m')}}">詳細</a>
                        </td>
                    </tr>
                @endforeach
        </table>
    </div>
</main>
<a class="btn btn-original" href="/admin_top">戻る</a>
@endsection








