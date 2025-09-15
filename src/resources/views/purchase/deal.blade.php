@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/deal.css') }}">
@endsection

@section('content')
<form action="{{ route('deal.submit', ['item_id'=>$item->id]) }}" method="post">
    @csrf
    <div class="deal-contents">
        <div class="deal-left">
            <p>その他の取引</p>
        </div>
        <div class="deal-right">
            
        </div>
    </div>
</form>
@endsection