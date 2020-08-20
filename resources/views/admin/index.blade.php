@extends('layouts.default')

@section('title' , $title)

@include('head.head')

@section('content')
<!-- 管理者用ページ -->
    <h1 class='page-title'>{{ $title}}</h1>
    <!-- エラ〜メッセージを出力 -->
    @foreach($errors->all() as $error)
    <p class="error alert alert-danger" role="alert">{{ $error }}</p>
    @endforeach

    <main class='flex main'> 
        @component('components.chat')
            @slot('messages' ,$messages)
        @endcomponent
        <section class="wrap attendance_box">
            <ul>
                @component('components.worktime')
                    @slot('record' ,$record)
                    @slot('leave_work' ,$leave_work)
                @endcomponent
                <li>
                    <h5 class='sub-title'>ユーザ機能</h5>
                    <ul>
                        <li class="btn" ><a href="/work/{{ date('Y-n') }}">勤務管理ページ</a></li>
                        <li class="btn" ><a href="/holiday/{{ date('Y-n') }}">休日申請ページ</a></li>
                    </ul>
                </li>
                <li>
                    <h5 class="sub-title">管理者機能</h5>
                    <ul >
                        <li class="btn" ><a href="/day/{{ date('Y-m-d') }}">勤務情報</a></li>
                        <li class="btn" ><a href="/user">ユーザ一覧</a></li>
                        <li class="btn" ><a href="/application">申請確認</a></li>
                        <li class="btn" ><a href="/admin/register">社員登録ページ</a></li>
                    </ul>
                </li>
                <li>
                    @component('components.stamping')
                        @slot('record' ,$record)
                    @endcomponent
                </li>
            </ul>
        </section>       
    </main>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-git.slim.min.js"></script>
    <script>
        $(".chat").scrollTop($(".chat")[0].scrollHeight);
    </script>
@endsection



