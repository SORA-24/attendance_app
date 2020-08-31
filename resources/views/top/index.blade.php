@extends('layouts.default')

@section('title' , $title)

@include('head.head')

@section('content')
<!-- ユーザページ -->
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
                <li class="btn btn-original" ><a href="/work/{{ date('Y-n') }}">勤務管理ページ</a></li>
                <li class="btn btn-original" ><a href="/holiday/{{ date('Y-n') }}">休日申請ページ</a></li>
                <li>
                <li class="btn btn-original" ><a href="/overtime">残業申請ページ</a></li>
                <li>
                    @component('components.stamping')
                        @slot('record' ,$record)
                    @endcomponent
                </li>
                <li>
                    @component('components.addcomment')
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



