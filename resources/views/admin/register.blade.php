@extends('layouts.default')

@include('head.head')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">登録</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                    <!-- 名前 -->
                        <!-- エラーであればhas-errorというクラスを与える -->
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">名前</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                <!-- エラーがあれば、、$errorに入っているnameエラーを表示する -->
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    <!-- 所属 -->
                        <div class="form-group{{ $errors->has('belong') ? ' has-error' : '' }}">
                            <label for="belong" class="col-md-4 control-label">所属</label>
                            <div class="col-md-6">
                                <select name="belong_id" required>
                                    @foreach(config('const.BELONG') as $key => $val)
                                    <option value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('belong'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('belong') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    <!-- パスワード -->
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">パスワード</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    <!-- 確認用パスワード -->
                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">確認用パスワード</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                    <!-- 送信 -->
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    ユーザ登録
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<a class="btn btn-original" href="/admin_top">戻る</a>
@endsection