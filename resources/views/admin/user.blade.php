@extends('layouts.default')
@include('head.head')
@section('title' , $title)
@section('content')
<?php $ths = ["ID","氏名","残業時間","年休取得数","詳細ページ"]?> 
<h1>{{ "７月".$title }}</h1>
    @foreach($errors->all() as $error)
        <p class="error">{{ $error }}</p>
    @endforeach

<main>
    <div>
        <div class="search_box">
            <form action="/user" >
                <input type="search" name="keyword_name" placeholder='氏名を入力してください' class='content-width'>
                <input type="submit" value="検索">
            </form>
        </div>
    </div>
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
                        <td></td>
                        <td></td>
                        <td>
                            <a href="/admin/user_id{{$val->id}}/{{date('Y-m')}}">詳細</a>
                        </td>
                    </tr>
                @endforeach
        </table>
    </div>
</main>
<a class="btn btn-original" href="/admin_top">戻る</a>
@endsection
