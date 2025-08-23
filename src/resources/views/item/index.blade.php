@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/index.css') }}">
@endsection

@section('content')
<div class="items-contents">
    <div class="items-heading">
        <h2 class="items-heading-label">おすすめ</h2>
        <h2 class="items-heading-label">マイリスト</h2>
    </div>
    <div class="items-list">
        @foreach ($items as $item)
        <div class="item-card">
            <a href=" {{ route('item.detail', ['item_id'=>$item->id]) }}">
                <img src=" {{ asset('storage/'.$item->image) }}" alt="">
                <p>{{ $item->name }}</p>
            </a>
        </div>
        
        @endforeach
    </div>
</div>
@endsection