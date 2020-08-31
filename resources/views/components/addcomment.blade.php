<form action="/top/add_comment" method="post">
    {{ csrf_field() }}
    <div class="btn-group">
        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">コメント</button>
        <div class="dropdown-menu comment-wrapper">
            <div>{{date("Y年n月j日")}}のコメント</div>
            <div>
                <textarea name="comment" class="comment" placeholder="記録用コメントです">@isset($record->comment){{$record->comment}}@endisset</textarea>
            </div>
                <div>
                <input class="btn btn-outline-primary" type="submit" value="記録する">
            </div>
        </div>
    </div>
</form>
    