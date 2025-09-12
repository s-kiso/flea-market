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
                            <a href="{{route('purchase.payment',['item_id'=>$item->id, 'type'=>'card']) }}"><button type="button" class="selected">カード支払い</button></a>
                        @elseif($type=="card")
                            <a href="{{route('purchase.payment',['item_id'=>$item->id, 'type'=>'convenience']) }}"><button type="button" class="selected">コンビニ払い</button></a>
                        @else
                            <a href="{{route('purchase.payment',['item_id'=>$item->id, 'type'=>'convenience']) }}"><button type="button" class="selected">コンビニ払い</button></a>
                        @endif
                    </li>
                    @if($type==null)
                    <li>
                        <a href="{{route('purchase.payment',['item_id'=>$item->id, 'type'=>'card']) }}"><button type="button" class="selected">カード支払い</button></a>
                    </li>
                    @endif
                </ul>
            </div>
            <div class="form-error">
                @error('payment')
                {{$message}}
                @enderror
            </div>
            <div class="address">
                <div class="address-top">
                    <h3>配送先</h3>
                    <a href="{{ route('address.modify', ['item_id'=>$item->id]) }}" class="address-modify">変更する</a>
                </div>
                <div class="address-detail">
                    @if($modified_address == null)
                        <p>〒{{ $user->postal_code }}</p>
                        <p>{{ $user->address }}</p>
                        <p>{{ $user->building }}</p>
                        <input type="hidden" name="postal_code" value="{{ $user->postal_code }}">
                        <input type="hidden" name="address" value="{{ $user->address }}">
                        <input type="hidden" name="building" value="{{ $user->building }}">
                        <input type="hidden" name="condition" value="0">
                    @else
                        〒{{ $modified_address->postal_code }}</p>
                        <p>{{ $modified_address->address }}</p>
                        <p>{{ $modified_address->building }}</p>
                        <input type="hidden" name="postal_code" value="{{ $modified_address->postal_code }}">
                        <input type="hidden" name="address" value="{{ $modified_address->address }}">
                        <input type="hidden" name="building" value="{{ $modified_address->building }}">
                        <input type="hidden" name="condition" value="1">
                    @endif
                </div>
            </div>
            <div class="form-error">
                @error('address')
                {{$message}}
                @enderror
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
                @if($purchase_check == 'purchased')
                    <button class="purchased-form-button" disabled>Sold</button>
                @else
                    <button type="submit" class="purchase-form-button">購入する</button>
                @endif
            </div>
        </div>
    </div>
</form>
@endsection