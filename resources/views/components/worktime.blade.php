<li>
    <p>{{ '本日は' . date('Y年n月j日') . 'です'}}</p>
</li>
<li>
    <div>
        @if("" !== $record)
            出勤時刻{{ date('H:i:s' ,strtotime($go_work = $record->go_work)) }}
        @else
            出勤時刻 まだ出勤していません
        @endif
    </div>
</li>
<li>
    <div>
        @if( !empty ($record->temporarily))
            休憩中です
        @elseif(!empty ( $go_work ))
            退勤予定{{ $leave_work }}
        @else
            退勤予定  まだ出勤していません
        @endif
    </div>
</li>
<li>
    <div>
        @if( !empty ($record->break_time))
            本日の休憩時間 
            @component('components.time')
                @slot('time' , $record->break_time)
            @endcomponent
        @else
        @endif
    </div>
</li>
<li>
    <div>
        現在の勤務時間
        <!-- 勤務時間 => $working-->
        @isset($record->go_work)
            @isset($record->leave_work)
            @php 
            $working = strtotime($record->leave_work) - strtotime($record->go_work)- $record->break_time 
            @endphp
                @component('components.time')
                    @slot('time' , $working)
                @endcomponent
            @endisset
            @empty($record->leave_work)
            @php 
            $working = strtotime(now()) - strtotime($record->go_work)- $record->break_time 
            @endphp
                @component('components.time')
                    @slot('time' , $working)
                @endcomponent
            @endempty
        @endisset
    </div>
</li>
