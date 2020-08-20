@extends('layouts.app')

@section('title' , $title)

@include('head.head')

@section('content')

<form action="/hello/auth" method='post'>
<table>
    {{csrf_field()}}
    <tr>
        <tr>
            <th>id:</th>
            <td><input type="text" name="id"></td>
        </tr>
        <tr>
            <th>パスワード</th>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <th></th>
            <td><input type="submit" name="send"></td>
        </tr>
    </tr>
</table>
</form>



@endsection
