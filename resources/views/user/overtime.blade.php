@extends('layouts.default')
@include('head.head')
@section('title' , $title)
@section('content')
<h1 class="page-title">{{ $title }}</h1>

<p>{{ "本日は" . date('Y年n月j日' . '日です')}}</p>
@foreach($errors->all() as $error)
    <p class="error alert alert-danger" role="alert">{{ $error }}</p>
@endforeach

<main class="wrap">
    <h5 class="sub-title">残業申請をする</h5>
    <form action="/overtime/application" method="post">
        {{ csrf_field() }}
        <input type="date" name="date" value="{{old('date')}}">
            <div>開始時間
                <select name="start_h">
                    <option value="{{ old('start_h') }}">{{ old('start_h') }}</option>
                    @for($h = 0 ; $h  <= 23 ;$h ++ )
                    <option value="{{$h}}">{{$h}}</option>
                    @endfor
                </select>
                <label for="start_h">時</label>
                <select name="start_m">
                    <option value="{{ old('start_m') }}">{{ old('start_m') }}</option>
                    @for($m = 0 ; $m  <= 59 ;$m +=30 )
                    <option value="{{$m}}">{{$m}}</option>
                    @endfor
                </select>
                <label for="start_m">分</label>
            </div>
            <div>終了時間
            <select name="end_h">
                <option value="{{ old('end_h') }}">{{ old('end_h') }}</option>
                @for($h = 0 ; $h  <= 23 ;$h ++ )
                <option value="{{$h}}">{{$h}}</option>
                @endfor
            </select>
                <label for="end_h">時</label>
                <select name="end_m">
                    <option value="{{ old('end_m') }}">{{ old('end_m') }}</option>
                    @for($m = 0 ; $m  <= 59 ;$m +=30 )
                    <option value="{{$m}}">{{$m}}</option>
                    @endfor
                </select>
                <label for="end_m">分</label>
            </div>
            <div>
                <input type="text" name="comment" value="{{old('comment')}}" placeholder="残業理由を書いてください">
            </div>
        <input type="submit" value="申請する"> 
    </form>
</main>
<a class="btn btn-original" href="/top">戻る</a>
@endsection