<li>
    <p>{{ '本日は' . date('Y年n月j日') . 'です'}}</p>
</li>
<li>
    <h5>
        @if("" !== $record)
            出勤時刻{{ date('H:i:s' ,strtotime($go_work = $record->go_work)) }}
        @else
            出勤時刻 まだ出勤していません
        @endif
    </h5>
</li>
<li>
    <h5>
        @if( !empty ($record->temporarily))
            休憩中です
        @elseif(!empty ( $go_work ))
            退勤予定{{ $leave_work }}
        @else
            退勤予定  まだ出勤していません
        @endif
    </h5>
</li>
<li>
    <h5>
        @if( !empty ($record->break_time))
            本日の休憩時間 
            @component('components.time')
                @slot('time' , $record->break_time)
            @endcomponent
        @else
        @endif
    </h5>
</li>