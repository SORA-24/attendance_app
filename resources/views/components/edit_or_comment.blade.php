@if( Auth::user()->user_type === 2 && isset($edit_status))
    @php $day = str_pad($i , 2 ,'0',STR_PAD_LEFT); @endphp
    <td>
    <form action="/admin/record_edit">
        <input type="hidden" name="d" value="{{$year}}-{{$month}}-{{$day}}" >
        <input type="hidden" name="user_id" value="{{$record->user_id}}">
        <input type="submit" value="{{$i}}日を編集">
    </form>
    </td>
@elseif(empty($edit_status))
    <td>
        @isset($record->comment)
            {{$record->comment}}
        @endisset
    </td>
@endif