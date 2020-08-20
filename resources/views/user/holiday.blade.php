@extends('layouts.default')
@include('head.head')
@section('title' , $title)
@section('content')
    <h1 class="page-title">{{ $title }}</h1>
    
    <p>{{ '本日は' . date('Y年n月j日') . 'です'}}</p>
    @foreach($errors->all() as $error)
    <p class="error alert alert-danger" role="alert">{{ $error }}</p>
    @endforeach
    <main class="calendar">
        <table>
        <div class="month">
            <a class="btn btn-original" href="/holiday/{{ $year}}-{{ $month -1 }}">前月へ</a>
            <h5 class="main-title">{{$year . '年' . $month .'月' }}</h5>
            <a class="btn btn-original" href="/holiday/{{ $year}}-{{ $month +1 }}">次月へ</a>
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
                            <form action="/holiday/paid_holiday" method='post'>
                                {{csrf_field()}}
                                <input type="hidden" name="holiday" value='{{ date("Y-m-d" , strtotime("${year}-${month}-${i}")) }}'>
                                <input type="submit" value="{{$i}}" class="calendar__submit">
                            </form>
                        </td>
                @elseif(date('w', strtotime("${year}-${month}-${i}")) % 7 == 6 )
                <!-- 土曜日 -->
                <td class="blue @if( date('Y-m-d') == date('Y-m-d', strtotime("${year}-${month}-${i}"))) today_red @endif">
                            <form action="/holiday/paid_holiday" method='post'>
                                {{csrf_field()}}
                                <input type="hidden" name="holiday" value='{{ date("Y-m-d" , strtotime("${year}-${month}-${i}")) }}'>
                                <input type="submit" value="{{$i}}" class="calendar__submit">
                            </form>
                        </td>
                    </tr>
                @else
                <!-- 平日 -->
                <td class="@if( date('Y-m-d') == date('Y-m-d', strtotime("${year}-${month}-${i}"))) today_red @endif">
                        <form action="paid_holiday" method='post'>
                            {{csrf_field()}}
                            <input type="hidden" name="holiday" value='{{ date("Y-m-d" , strtotime("${year}-${month}-${i}")) }}'>
                            <input type="submit" value="{{$i}}" class="calendar__submit">
                        </form>
                    </td>
                @endif 
            @endfor
            </tr>
        </table>
    </main>
        <a class="btn btn-original" href="/top">戻る</a>
@endsection