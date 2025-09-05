@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/index.css') }}">
@endsection

@section('content')
<form action="{{ route('purchase.submit', ['item_id'=>$item->id]) }}" method="post">
    @csrf
    <div class="purchase-contents">
        <div class="purchase-left">
            <div class="item-detail">
                <div class="item-img">
                    <img src="{{ asset('storage/'.$item->image) }}" alt="">
                </div>
                <div class="item-name">
                    <h2>{{ $item->name }}</h2>
                    <p class="item-price">¥ {{ number_format($item->price) }}</p>
                </div>
            </div>
            <div class="payment">
                <h3>支払い方法</h3>
                <input type="checkbox" class="payment-select-default" id="label-1">
                <div class="default-label">
                    <label class='default' for="label-1">
                        @if($type=="convenience")
                            コンビニ払い
                            <input type="hidden" name="payment" value="convenience">
                        @elseif($type=="card")
                            カード支払い
                            <input type="hidden" name="payment" value="card">
                        @else
                            選択してください
                        @endif
                    </label>
                </div>
                <ul class="payment-select">
                    <li>
                        @if($type=="convenience")
                            <button type="button" class="selected"><a href="{{route('purchase.payment',['item_id'=>$item->id, 'type'=>'card']) }}">カード支払い</a></button>
                        @elseif($type=="card")
                            <button type="button" class="selected"><a href="{{route('purchase.payment',['item_id'=>$item->id, 'type'=>'convenience']) }}">コンビニ払い</a></button>
                        @else
                            <button type="button" class="selected"><a href="{{route('purchase.payment',['item_id'=>$item->id, 'type'=>'convenience']) }}">コンビニ払い</a></button>
                        @endif
                    </li>
                    @if($type==null)
                    <li>
                        <button type="button" class="selected"><a href="{{route('purchase.payment',['item_id'=>$item->id, 'type'=>'card']) }}">カード支払い</a></button>
                    </li>
                    @endif
                </ul>
            </div>
            <div class="address">
                <div class="address-top">
                    <h3>配送先</h3>
                    <a href="{{ route('address.modify', ['item_id'=>$item->id]) }}" class="address-modify">変更する</a>
                </div>
                <div class="address-detail">
                    <p>〒{{ $user->postal_code }}</p>
                    <p>{{ $user->address }}</p>
                    <p>{{ $user->building }}</p>
                </div>
            </div>
        </div>
        <div class="purchase-right">
            <div class="summary">
                <div class="summary-price">
                    <p class="summary-label">商品代金</p>
                    <p class="summary-main">¥{{number_format($item->price)}}</p>
                </div>
                <div class="summary-payment">
                    <p class="summary-label">支払い方法</p>
                    <p class="summary-main">
                        @if($type=="convenience")
                            コンビニ払い
                        @elseif($type=="card")
                            カード支払い
                        @else
                            選択してください
                        @endif
                    </p>
                </div>
            </div>
            <div class="purchase-form">
                <button type="submit" class="purchase-form-button">購入する</button>
            </div>
        </div>
    </div>
</form>
@endsection