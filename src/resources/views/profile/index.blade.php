@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile/index.css') }}">
@endsection

@section('content')
<div class="items-contents">
    <div class="mypage-user">
        <div class="user-image"><img src="{{ asset('storage/'.$user->image) }}" alt=""></div>
        <h2 class="user-name">{{ $user->name }}</h2>
        <a href="/mypage/profile" class="user-edit">プロフィールを編集</a>
    </div>
    <div class="items-heading">
        <h3 class="items-heading-label">出品した商品</h3>
        <h3 class="items-heading-label">購入した商品</h3>
    </div>
    <div class="items-list">
        @foreach ($items as $item)
        <a href=" {{ route('item.detail', ['item_id'=>$item->id]) }}">
            <div class="item-card">
                <div class="item-card-image">
                    <img src=" {{ asset('storage/'.$item->image) }}" alt="">
                </div>
                <div class="item-card-label">
                    <p>{{ $item->name }}</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection