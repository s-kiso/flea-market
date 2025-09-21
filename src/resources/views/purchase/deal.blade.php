@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/deal.css') }}">
@endsection

@section('content')
<div class="deal-contents">

    <div class="deal-left">
        <p class="deal-left-top">その他の取引</p>
        <div class="deal-left-contents">
            <ul>
                @foreach($dealing_items as $dealing_item)
                <div class="deal-left-list">
                    <a href="{{ route('item.deal', ['item_id'=>$dealing_item->id]) }}">
                        <li>{{ $dealing_item->name }}
                        @if($dealing_item->unread_number !== 0)
                            <p class="item-card-unread-number">{{ $dealing_item->unread_number }}</p>
                        @endif
                        </li>
                    </a>
                </div>
                @endforeach
            </ul>
        </div>

    </div>
    <div class="deal-right">
        <div class="deal-header">
            <div class="client-img">
                <img src="{{ asset('storage/'.$client_user->image) }}" alt="">
            </div>
            <h2>「{{ $client_user->name }}」さんとの<wbr />取引画面</h2>
            @if($user_type == "buyer")
                <button type="button" class="deal-submit-button" popovertarget="popover" popovertargetaction="show">取引を完了する</button>
            @endif
        </div>
        <div class="item-detail">
            <div class="item-img">
                <img src="{{ asset('storage/'.$item->image) }}" alt="">
            </div>
            <div class="item-info">
                <h3 class="item-name">{{ $item->name }}</h3>
                <p class="item-price">¥{{ number_format($item->price) }}（税込）</p>
            </div>
        </div>
        <div class="deal-chat">
            @foreach($messages as $i => $message)
                @if($message->user_type == $user_type)
                    <div class="my-chat">
                        <div class="my-info">
                            <p class="chat-name">{{ $my_user->name }}</p>
                            <img src="{{ asset('storage/'.$my_user->image) }}" alt="" class="chat-image">
                        </div>
                        <div class="my-message">
                            @if($edit_id == $i && $edit_type == 'message')
                                <div class="form-error-modify">
                                    @error('modify_message')
                                    {{$message}}
                                    @enderror
                                </div>
                                <form action="{{ route('chat.modify', ['item_id'=>$item->id]) }}" class="chat-modify-form" method="post">
                                    @csrf
                                    <textarea name="modify_message" placeholder="{{ $message->message }}" class="chat-modify-textarea">{{ old('modify_message') }}</textarea>
                                    <div class="edit-buttons">
                                        <button type="submit" class="edit-submit-button" id="chat-modify-submit"></button>
                                        <label for="chat-modify-submit" class="edit-button-label">修正</label>
                                        <a href="{{ route('item.deal', ['item_id'=>$item->id]) }}" class="edit-button-label">戻る</a>
                                    </div>
                                    <input type="hidden" name="edit_id" value="{{ $message->id }}">
                                    <input type="hidden" name="edit_type" value="message">
                                </form>
                            @else
                                <p class="my-chat-message-main">{{ $message->message }}</p>
                                <form action="{{ route('chat.delete', ['item_id'=>$item->id]) }}" class="chat-modify-button" method="post">
                                    @csrf
                                    <div class="edit-buttons">
                                        <a href="{{ route('item.deal', ['item_id'=>$item->id, 'edit'=>$i, 'type'=>'message' ]) }}" class="edit-button-label">編集</a>
                                        <button type="submit" class="edit-submit-button" id="message-delete[{{$message->id}}]"></button>
                                        <label for="message-delete[{{$message->id}}]" class="edit-button-label">削除</label>
                                        <input type="hidden" name="edit_id" value="{{ $message->id }}">
                                        <input type="hidden" name="edit_type" value="message">
                                    </div>
                                </form>
                            @endif
                            @if($message->image !== null)
                                @if($edit_id == $i && $edit_type == 'image')
                                    <form action="{{ route('image.modify', ['item_id'=>$item->id]) }}" enctype="multipart/form-data" class="chat-modify-form" method="post">
                                    @csrf
                                        <div class="form-error-modify">
                                            @error('modify_image')
                                            {{$message}}
                                            @enderror
                                        </div>
                                        <div class="edit-image">
                                            <img src="{{ asset('storage/'.$message->image) }}" alt="" class="edit-image">
                                            <input type="file" name="modify_image" class="edit-file-input" id="edit-file-input">
                                            <label for="edit-file-input" class="edit-file-label">画像を変更</label>
                                        </div>
                                        <div class="edit-buttons">
                                            <button type="submit" class="edit-submit-button" id="chat-modify-submit"></button>
                                            <label for="chat-modify-submit" class="edit-button-label">修正</label>
                                            <a href="{{ route('item.deal', ['item_id'=>$item->id]) }}" class="edit-button-label">戻る</a>
                                        </div>
                                        <input type="hidden" name="edit_id" value="{{ $message->id }}">
                                        <input type="hidden" name="edit_type" value="image">
                                    </form>
                                @else
                                    <img src="{{ asset('storage/'.$message->image) }}" alt="" class="chat-message-image">
                                    <form action="{{ route('chat.delete', ['item_id'=>$item->id]) }}" class="chat-modify-button" method="post">
                                        @csrf
                                        <div class="edit-buttons">
                                            <a href="{{ route('item.deal', ['item_id'=>$item->id, 'edit'=>$i, 'type'=>'image']) }}" class="edit-button-label">編集</a>
                                            <button type="submit" class="edit-submit-button" id="image-delete[{{$message->id}}]"></button>
                                            <label for="image-delete[{{$message->id}}]" class="edit-button-label">削除</label>
                                            <input type="hidden" name="edit_id" value="{{ $message->id }}">
                                            <input type="hidden" name="edit_type" value="image">
                                        </div>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                @else
                <div class="client-chat">
                    <div class="client-info">
                        <img src="{{ asset('storage/'.$client_user->image) }}" alt="" class="chat-image">
                        <p class="chat-name">{{ $client_user->name }}</p>
                    </div>
                    <div class="client-message">
                        <p class="client-chat-message-main">{{ $message->message }}</p>
                        @if($message->image !== null)
                            <img src="{{ asset('storage/'.$message->image) }}" alt="" class="chat-message-image">
                        @endif
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        <div class="form-error">
            @error('chat')
            {{$message}}
            @enderror
        </div>
        <div class="form-error">
            @error('image')
            {{$message}}
            @enderror
        </div>
        <form action="{{ route('chat.submit', ['item_id'=>$item->id]) }}" enctype="multipart/form-data" method="post" class="deal-chat-form">
            @csrf
            <textarea name="chat" placeholder="取引メッセージを記入してください" class="send-message">{{ old('chat') }}</textarea>
            <input type="file" name="image" class="send-file-input" id="send-file-input">
            <label for="send-file-input" class="send-file-label">画像を追加</label>
            <input type="hidden" name="user_type" value="{{ $user_type }}">
            <input type="image" class="chat-submit-button" src="{{ asset('storage/'.'inputbutton.jpg') }}" alt="" @if($condition == "3") disabled @endif>
        </form>
    </div>
</div>

<div id="popover" @if($condition <> "3") class="popover-content"  popover @else class="popover-content-fix" @endif>
    <p class="popover-complete">取引が完了しました。</p>
    <form action="{{ route('deal.submit', ['item_id'=>$item->id]) }}" method="post" class="popover-submit-form">
        @csrf
        <p>今回の取引相手はどうでしたか？</p>
        <div class="popover-rate">
            @for($j = 0; $j < 5; $j++)
            <input type="radio" name="rate" id="star[{{ $j }}]" value="{{ $j }}" class="rate-stars">
            <label for="star[{{ $j }}]" class="star">★</label>
        @endfor
        </div>
        <button type="submit" class="popover-submit-button">送信する</button>
        <input type="hidden" name="type" value="{{$user_type}}">
    </form>
</div>
@endsection