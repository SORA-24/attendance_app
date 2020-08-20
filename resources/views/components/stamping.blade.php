<div>
    <form method='post' action="/top/stamping">
        {{ csrf_field() }}
        @isset($record->go_work)
        <input type="submit" name='leave_work' value="退勤">
        @endisset
        @empty($record->temporarily)
        <input type="submit" name='stop_work' value="休憩">
        @endempty
        @empty($record->go_work)
        <div class='all-bg'>
            <div class='msg-box'>
                <h5 class="msg">未出勤です</h5>
                <input class='input-btn' type="submit" name='go_work' value="出勤">
            </div>
        </div>
        @endempty
        @isset($record->temporarily)
        <div class='all-bg'>
            <div class='msg-box'>
                <h5 class="msg">休憩中です</h5>
                <input class='input-btn' type="submit" name='restart_work' value="再開">
            </div>
        </div>
        @endisset
    </form>
</div>
