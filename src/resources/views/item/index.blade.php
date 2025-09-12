@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/index.css') }}">
@endsection

@section('content')
<div class="items-contents">
    <div class="items-heading">
        @if($type == "mylist")
            <h2 class="items-heading-label"><a href="/">おすすめ</a></h2>
            <h2 class="items-heading-label-selected"><a href="/?tab=mylist">マイリスト</a></h2>
        @else
            <h2 class="items-heading-label-selected"><a href="/">おすすめ</a></h2>
            <h2 class="items-heading-label"><a href="/?tab=mylist">マイリスト</a></h2>
        @endif
    </div>
    <div class="items-list">
        @foreach ($items as $item)
            @if($item->purchase_check == 'purchased')
                <div class="item-card-sold">
                    <a href=" {{ route('item.detail', ['item_id'=>$item->id]) }}">
                        <div class="item-card-sold-image">
                            <p class="item-description-sold">sold</p>
                            <img src=" {{ asset('storage/'.$item->image) }}" alt="">
                        </div>
                        <p class="item-name">{{ $item->name }}</p>
                    </a>
                </div>
            @else
                <div class="item-card">
                    <a href=" {{ route('item.detail', ['item_id'=>$item->id]) }}">
                        <img src=" {{ asset('storage/'.$item->image) }}" alt="">
                        <p>{{ $item->name }}</p>
                    </a>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection