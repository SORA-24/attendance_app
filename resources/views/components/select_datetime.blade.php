{{-- 
@component('components.select_datetime')
    @isset($record->go_work)
        @slot('time' , $record->go_work)
    @endisset
    @empty($record->go_work)
        @slot('time' , '0:0:0')
    @endempty
        @slot('name' , 'go_work')
@endcomponent
--}}
@php
    $hour = date('H' , strtotime($time));
    $minute = date('i' , strtotime($time));
    $second = date('s' , strtotime($time));
@endphp
<select name="{{$name}}_h">
    <option value="{{$hour}}">{{$hour}}</option>
    @for($h = 0 ; $h  <= 23 ;$h ++ )
        <option value="{{$h}}">{{$h}}</option>
    @endfor
</select>
<select name="{{$name}}_m">
    <option value="{{$minute}}">{{$minute}}</option>
    @for($m = 0 ; $m  <= 59 ;$m += 15 )
        <option value="{{$m}}">{{$m}}</option>
    @endfor
</select>
<select name="{{$name}}_s">
    <option value="{{$second}}">{{$second}}</option>
    <option value="0">0</option>
</select>