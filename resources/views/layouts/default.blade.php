<!DOCTYPE html>
<html lang="en">
<head>
    @yield('head')
</head>
<body>
    <section class="side_menu">
        <ul>
            <li class="btn" ><a href="/top">トップページ</a></li>
            <li class="btn" ><a href="/work">勤務管理ページ</a></li>
            <li class="btn" ><a href="/holiday">休日申請ページ</a></li>
        </ul>
    </section>
    <header class='header'>
        <h1 class='header_title'>勤怠システム</h1>
        <p class='header_user_name'>現在のユーザー名: {{ Auth::user()->name }} </p>
    </header>
    <article class="wrapper">
        <div class="inner">
            <!-- フラッシュメッセージ -->
            @if (session('flash_message'))
            <div class="flash_message alert alert-primary" role="alert">
                    {{ session('flash_message') }}
                </div>
            @endif
            @yield('content')
        </div>
    </article>
    <footer>
        <form action="{{ url('/logout') }}" method="post">
            {{ csrf_field() }}
            <button type="submit">ログアウト</button>
        </form>
    </footer>
    <!-- bootstarap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>