@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/index.css') }}">
@endsection

@section('content')
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
                <label class='default' for="label-1">選択してください</label>
            </div>
                <ul class="payment-select">
                    <li>
                        <input type="hidden" name="search_data" value="{{$product_name ?? '' }}">
                        <button type="button" class="selected"><a href="{{route('purchase.payment',['item_id'=>$item->id, 'type'=>'convenience']) }}">コンビニ払い</a></button>
                    </li>
                    <li>
                        <input type="hidden" name="search_data" value="{{$product_name ?? '' }}">
                        <button type="button" class="selected"><a href="{{route('purchase.payment',['item_id'=>$item->id, 'type'=>'card']) }}">カード支払い</a></button>
                    </li>
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
    <div class="purchase_right">
        <div class="summary">
            <div class="summary-price">
                <p>商品代金</p>
                <p>{{ $item->price }}</p>
            </div>
            <div class="summary-payment">
                <p>支払方法</p>
                {{-- @if()
                    <p></p>
                @else
                    <p></p>
                @endif --}}
                <p>コンビニ払い</p>
            </div>
        </div>
    </div>
</div>
@endsection