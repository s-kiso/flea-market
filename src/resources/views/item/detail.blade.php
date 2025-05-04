@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/detail.css') }}">
@endsection

@section('content')
<div class="detail-contents">
    <div class="detail-left">
        <div class="detail-image">
            <img src=" {{ asset('storage/'.$item->image) }}" alt="">
        </div>
    </div>

    <div class="detail-right">
        <div class="item-h2">
            <h2>{{ $item->name }}</h2>
        </div>
        <div class="item-brand">
            <p>{{ $item->brand }}</p>
        </div>
        <div class="item-price">
            <p>{{ $item->price }}</p>
        </div>
        <div class="item-reaction">
            <div class="item-reaction-likes">
                <img src="{{ asset('storage/'.'star.png') }}" alt="">
                <!-- ここにlikesテーブルからlike数持ってくる -->
            </div>
            <div class="item-reaction-comments">
                <img src="{{ asset('storage/'.'comment.png') }}" alt="">
                <!-- ここにlikesテーブルからlike数持ってくる -->
            </div>
        </div>
        <a class="item-purchase-form" href="/purchase/:{{ $item->id }}">購入手続きへ</a>
        <div class="item-detail">
            <h3>商品説明</h3>
            <p>{{ $item->description }}</p>
        </div>
        <div class="item-infomation">
            <h3>商品の情報</h3>
            <h4>カテゴリー</h4>
            <h4>商品の状態</h4>
            {{ $condition }}
        </div>
        <div class="item-comments">
            <h3>コメント</h3>
            <h4>商品へのコメント</h4>
            <input type="text">
            <button type="submit" class="submit-button">コメントを送信する</button>
        </div>
    </div>
</div>
@endsection