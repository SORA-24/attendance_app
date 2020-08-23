@extends('layouts.default')
@include('head.head')
@section('title' , $title)
@section('content')
<h1>{{ $title }}</h1>
    @foreach($errors->all() as $error)
        <p class="error">{{ $error }}</p>
    @endforeach
<main>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <!-- ホーム -->
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">申請中</a>
        </li>
        <!-- 休日申請 -->
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="holidays-tab" data-toggle="tab" href="#holidays" role="tab" aria-controls="holidays" aria-selected="false">休日申請</a>
        </li>
        <!-- 残業申請 -->
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="overtimes-tab" data-toggle="tab" href="#overtimes" role="tab" aria-controls="overtimes" aria-selected="false">残業申請</a>
        </li>
    </ul>
<div class="tab-content" id="myTabContent">
    <!-- ホーム画面 -->
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="wrap">
                @if(count($holidays) > 0) 
                    <p>休日申請数 : {{ count($holidays) }} 件</p>
                @endif
                @if(count ($overtimes) > 0)
                    <p>残業申請数 : {{ count($overtimes) }} 件</p>
                @endif
                @if(count($holidays) < 1 && count ($overtimes) < 1) 
                <p>現在申請されている情報はありません</p>
                @endif
        </div>
    </div>
    <!-- 休日申請 -->
    <div class="tab-pane fade table_box" id="holidays" role="tabpanel" aria-labelledby="holidays-tab">
    @if(count($holidays) > 0 )
        <table class="">
            <tr>
            @php $ths = ['id','氏名','申請日時','申請状況','登録'] @endphp
                @foreach($ths as $th)
                    <th>{{ $th }}</th>
                @endforeach
            </tr>
                @foreach($holidays as $val) 
            <tr>
                <td>{{ $val->user_id}}</td>
                <td>{{ $val->name}}</td>
                <td>{{ $val->date}}</td>
                <td>申請中</td>
                <td><form action="/application/register" method="post">
                {{csrf_field()}}
                    <input type="hidden" name="record_id" value="{{ $val->id }}">
                    <input class="btn btn-outline-success" type="submit" value="登録">
                </form></td>
                </tr>
                @endforeach
        </table>
    @else
        <p>現在申請されている情報はありません</p>
    @endif
    </div>
    <!-- 残業申請 -->
    <div class="tab-pane fade table_box" id="overtimes" role="tabpanel" aria-labelledby="overtimes-tab">
    @if(count($overtimes) > 0 )
        <table class="">
        <tr>
        @php $ths = ['id','氏名','開始時間','終了時間','コメント','申請状況','登録'] @endphp
            @foreach($ths as $th)
                <th>{{ $th }}</th>
            @endforeach
        </tr>
            @foreach($overtimes as $val) 
        <tr>
            <td>{{ $val->user_id}}</td>
            <td>{{ $val->name}}</td>
            <td>{{ $val->starttime}}</td>
            <td>{{ $val->endtime}}</td>
            <td>{{ $val->comment}}</td>
            <td>申請中</td>
            <td><form action="/application/register" method="post">
            {{csrf_field()}}
                <input type="hidden" name="user_id" value="{{ $val->user_id }}">
                <input type="hidden" name="overtime_id" value="{{ $val->overtime_id }}">
                <input class="btn btn-outline-success" type="submit" value="登録">
            </form></td>
            </tr>
            @endforeach
    </table>
    @else
        <p>現在申請されている情報はありません</p>
    @endif
    </div>
</div>
</main>
<a class="btn btn-original" href="/admin_top">戻る</a>
@endsection