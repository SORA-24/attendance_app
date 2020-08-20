@extends('layouts.default')
@include('head.head')
@section('title' , $title)
@section('content')
<?php $ths = ['id','氏名','申請日時','申請状況','登録']?>
<h1>{{ $title }}</h1>
    @foreach($errors->all() as $error)
        <p class="error">{{ $error }}</p>
    @endforeach
<main>
    @if(count($data) > 0 )
    <table>
        <tr>
            @foreach($ths as $th)
                <th>{{ $th }}</th>
            @endforeach
        </tr>
            @foreach($data as $val) 
        <tr>
            <td>{{ $val->user_id}}</td>
            <td>{{ $val->name}}</td>
            <td>{{ $val->date}}</td>
            <td>申請中</td>
            <td><form action="/application/register" method="post">
            {{csrf_field()}}
                <input type="hidden" name="record_id" value="{{ $val->id }}">
                <input type="submit" value="登録">
            </form></td>
            </tr>
            @endforeach
    </table>
    @else
    <p>現在申請されている情報はありません</p>
    @endif
        
</main>
<a class="btn" href="/admin_top">戻る</a>
@endsection