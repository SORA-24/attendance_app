<section class="chat_wrapper" >
        <!-- メッセージ出力 -->
        <h4 class="chat_title">総務課chat</h4>
            <ul class="chat wrap">
                @forelse($messages as $message)
                    @if($message->room_id == 1)
                        @if($message->send_at_id == Auth::user()->id)
                        <li class='chat__container'>
                        @else
                        <li class='chat__container other'>
                        @endif
                            <p class='chat__sub'>{{ $message->name}}</p>
                            <div class='chat__message_block'>
                                <p class="chat__message">
                                    {{ $message->message}}
                                </p>
                            </div>
                            <p class='chat__sub'>{{ $message->created_at}}</p>
                        </li>
                    @endif
                @empty
                    <li>メッセージはありません</li>
                @endforelse
            </ul>
            <form method='post' action="/top/message_add">
                {{ csrf_field() }}
                <div class='msg_send_box'>
                    <input type="text" name="message" placeholder='メッセージを入力'>
                    <input type="hidden" name="room_id" value='1'>
                    <input type="submit" value="送信">
                </div>
            </form>
        </section>