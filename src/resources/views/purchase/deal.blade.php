@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/deal.css') }}">
@endsection

@section('content')
<form action="{{ route('deal.submit', ['item_id'=>$item->id]) }}" method="post">
    @csrf
    <div class="deal-contents">
        <div class="deal-left">
            <p class="deal-left-top">その他の取引</p>
            <div class="deal-left-contents">
                <ul>
                    @foreach($dealing_items as $dealing_item)
                    <a href="{{ route('item.deal', ['item_id'=>$item->id]) }}"><li>{{ $dealing_item->name }}</li></a>
                    @endforeach
                </ul>
            </div>
            
        </div>
        <div class="deal-right">
            <div class="deal-header">
                @if($user_type == "seller")
                    <div class="client-img">
                        <img src="{{ asset('storage/'.$buyer->image) }}" alt="">
                    </div>
                    <p>「{{ $buyer->name }}」さんとの取引画面</p>
                @else
                    <div class="client-img">
                        <img src="{{ asset('storage/'.$seller->image) }}" alt="">
                    </div>
                    <p>「{{ $seller->name }}」さんとの取引画面</p>
                    <form action="{{ route('deal.submit', ['item_id'=>$item->id]) }}" method="post">
                        @csrf
                        <button type="submit">取引を完了する</button>
                    </form>
                @endif
            </div>
            <div class="item-detail">
                <div class="item-img">
                    <img src="{{ asset('storage/'.$item->image) }}" alt="">
                </div>
                <div class="item-info">
                    <p class="item-name">{{ $item->name }}</p>
                    <p class="item-price">{{ $item->price }}</p>
                </div>
            </div>
            <div class="deal-chat">

            </div>
            <form action="/deal/chat" enctype="multipart/form-data" method="post" class="deal-chat-form">
                @csrf
                <input type="text" name="message" value="{{$message ?? '' }}" placeholder="取引メッセージを記入してください" class="send-message">
                <input type="file" class="form-file" name="image">
                <button type="submit">
                    <img src="{{ asset('storage/'.'inputbutton.jpg') }}" alt="">
                </button>
            </form>
        </div>
    </div>
</form>
@endsection