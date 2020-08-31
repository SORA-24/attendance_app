@if( Auth::user()->user_type === 2 && isset($edit_status))
    @php $day = str_pad($i , 2 ,'0',STR_PAD_LEFT); @endphp
    <td>
    <form action="/admin/record_edit">
        <input type="hidden" name="d" value="{{$year}}-{{$month}}-{{$day}}" >
        <input type="hidden" name="user_id" value="{{$user->id}}">
        <input type="submit" value="{{$i}}日を編集">
    </form>
    </td>
@elseif(empty($edit_status))
    <td>
        @isset($record->comment)
            <!-- Small button groups (default and split) -->
            <div class="btn-group">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">コメント...</button>
                <div class="dropdown-menu comment-wrapper">
                    <div class="dropdown-item comment" >{{$record->comment}}</div>
                    <!-- <a class="dropdown-item" href="#">編集</a> -->
                </div>
            </div>
            @endisset
        </td>
        @endif