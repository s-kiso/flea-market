@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile/index.css') }}">
@endsection

@section('content')
<div class="items-contents">
    <div class="mypage-user">
        <div class="user-image">
            <img src="{{ asset('storage/'.$user->image) }}" alt="">
        </div>
        <div class="user-info">
            <h2 class="user-name">{{ $user->name }}</h2>
            @if($star_yellow !== null)
                <div class="rate">
                    @for($i = 1; $i <= $star_yellow; $i++)
                        <img src="{{ asset('storage/'.'Star_yellow.png') }}" alt="">
                    @endfor
                    @for($j = 1; $j <= $star_white; $j++)
                        <img src="{{ asset('storage/'.'Star_white.png') }}" alt="">
                    @endfor
                </div>
            @endif
        </div>
        <a href="/mypage/profile" class="user-edit">プロフィールを編集</a>
    </div>
    <div class="items-heading">
    @if($type == "buy")
        <h3 class="items-heading-label">
            <a href="/mypage?tab=sell">出品した商品</a>
        </h3>
        <h3 class="items-heading-label-selected">
            <a href="/mypage?tab=buy">購入した商品</a>
        </h3>
        <h3 class="items-heading-label">
            <a href="/mypage?tab=deal">取引中の商品
                @if($unread_number !== 0)
                    <span class="items-heading-number">{{ $unread_number }}</span>
                @endif
            </a>
        </h3>
    @elseif($type == "deal")
        <h3 class="items-heading-label">
            <a href="/mypage?tab=sell">出品した商品</a>
        </h3>
        <h3 class="items-heading-label">
            <a href="/mypage?tab=buy">購入した商品</a>
        </h3>
        <h3 class="items-heading-label-selected">
            <a href="/mypage?tab=deal">取引中の商品
                @if($unread_number !== 0)
                    <span class="items-heading-number">{{ $unread_number }}</span>
                @endif
            </a>
        </h3>
    @else
        <h3 class="items-heading-label-selected">
            <a href="/mypage?tab=sell">出品した商品</a>
        </h3>
        <h3 class="items-heading-label">
            <a href="/mypage?tab=buy">購入した商品</a>
        </h3>
        <h3 class="items-heading-label">
            <a href="/mypage?tab=deal">取引中の商品
                @if($unread_number !== 0)
                    <span class="items-heading-number">{{ $unread_number }}</span>
                @endif
            </a>
        </h3>
    @endif
    </div>
    <div class="items-list">
        @if($type == "deal")
            @foreach ($items as $item)
                <a href="{{ route('item.deal', ['item_id'=>$item->id]) }}">
                    <div class="item-card">
                        <div class="item-card-image">
                            <img src=" {{ asset('storage/'.$item->image) }}" alt="">
                            @if($item->unread_number !== 0)
                                <p class="item-card-unread-number">{{ $item->unread_number }}</p>
                            @endif
                        </div>
                        <div class="item-card-label">
                            <p class="item-card-label-p">{{ $item->name }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        @else
            @foreach ($items as $item)
                <a href="{{ route('item.detail', ['item_id'=>$item->id]) }}">
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
        @endif
    </div>
</div>
@endsection