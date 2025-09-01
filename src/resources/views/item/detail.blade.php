@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/detail.css') }}">
@endsection

@section('content')
<div class="detail-contents">
    <div class="detail-left">
        <img src="{{ asset('storage/'.$item->image) }}" alt="">
    </div>

    <div class="detail-right">
        <div class="item-h2">
            <h2>{{ $item->name }}</h2>
        </div>
        <div class="item-brand">
            <p>{{ $item->brand }}</p>
        </div>
        <div class="item-price">
            <p>￥<span>{{ number_format($item->price) }}</span>（税込）</p>
        </div>
        <div class="item-reaction">
            <form action="/item/like" class="item-reaction-item" method="post">
                @csrf
                
                @if($likes_user == "true")
                    <input type="image" src="{{ asset('storage/'.'star_liked.png') }}" alt="" class="item-reaction-img">
                @else
                    <input type="image" src="{{ asset('storage/'.'star.png') }}" alt="" class="item-reaction-img">
                @endif
                <input type="hidden" name="status" value={{ $likes_user }}>
                <input  type="hidden" name="id" value="{{ $item->id }}">
                <p>{{ $likes_number }}</p>
            </form>
            <div class="item-reaction-item">
                <img src="{{ asset('storage/'.'comment.png') }}" alt="" class="item-reaction-img">
                <p>{{ $comments_number }}</p>
            </div>
        </div>
        <div class="item-purchase-form">
            <a href="/purchase/:{{ $item->id }}"><button>購入手続きへ</button></a>
        </div>
        
        <div class="item-detail">
            <h3>商品説明</h3>
            <p>{{ $item->description }}</p>
        </div>
        <div class="item-infomation">
            <h3>商品の情報</h3>
            <div class="item-information-block">
                <h4>カテゴリー</h4>
                @foreach($categories as $category)
                <p class="item-information-category">
                    {{ $category->name }}
                </p>
                @endforeach
            </div>
            <div class="item-information-block">
                <h4>商品の状態</h4>
                <p class="item-information-condition">{{ $condition }}</p>
            </div>
        </div>
        <div class="item-comments">
            <h3 class="item-comments-h3">コメント({{$comments_number}})</h3>
            @foreach($comments as $comment)
                <div class="item-comments-profile">
                    <div class="user_image"><img src="{{ asset('storage/'.$comment->image) }}" alt=""></div>
                    <p>{{ $comment->name }}</p>
                </div>
                <div class="item-comments-main">{{ $comment->pivot->comment }}</div>
            @endforeach
                
            <h4>商品へのコメント</h4>
            <form action="/item/comment" method="post">
                @csrf
                <textarea class="item-comments-textarea" name="comment"></textarea>
                <button type="submit" class="item-comments-button">コメントを送信する</button>
                <input  type="hidden" name="id" value="{{ $item->id }}">
            </form>
        </div>
    </div>
</div>
@endsection