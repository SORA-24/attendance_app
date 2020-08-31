<!DOCTYPE html>
<html lang="ja">
<head>
    @yield('head')
</head>
<body>
    </section>
        <header class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <a class="navbar-brand" href="/top">勤怠管理システム</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav ">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}}</a>
                        <div class="dropdown-menu">
                            <a class="btn btn-outline-secondary" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                ログアウト
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            <form method='post' action="/top/stamping">
                                {{ csrf_field() }}
                            <input class="btn btn-outline-dark" type="submit" name='leave_work' value="退勤">
                            <input class="btn btn-outline-primary" type="submit" name='stop_work' value="休憩">
                            </form>
                        </div>
                    </li>
                    <li class="nav-item active" ><a class="nav-link" href="/top">トップページ</a></li>
                    <li class="nav-item" ><a class="nav-link" href="/work/{{ date('Y-n') }}">勤務管理ページ</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">申請メニュー</a>
                            <div class="dropdown-menu">
                            <a class="btn btn-outline-secondary" href="/holiday/{{ date('Y-n') }}">休日申請ページ</a>
                            <a class="btn btn-outline-secondary" href="/overtime">残業申請ページ</a>
                            </div>
                    </li>
                    <li class="nav-item" ></li>
                    @if(Auth::user()->user_type == 2)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">管理者メニュー</a>
                        <div class="dropdown-menu">
                        <a class="btn btn-outline-secondary" href="/day/{{ date('Y-m-d') }}">勤務情報</a>
                        <a class="btn btn-outline-secondary" href="/user">ユーザ一覧</a>
                        <a class="btn btn-outline-secondary" href="/application">申請確認</a>
                        <a class="btn btn-outline-secondary" href="/admin/register">社員登録ページ</a>
                        </div>
                    </li>
                    @endif
                    
                </ul>
        </div>
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
        <div class="small">
            © sora.inc
        </div>
    </footer>
    <!-- bootstarap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>













