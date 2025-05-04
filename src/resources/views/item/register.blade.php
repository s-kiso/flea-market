@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/register.css') }}">
@endsection

@section('content')
<div class="register-contents">
    <div class="register-heading">
        <h2>商品の出品</h2>
    </div>

    <form action="/sell" class="register-form" enctype="multipart/form-data" method="post">
        <div class="register-image">
            <h3>商品画像</h3>
            <input type="file" name="image" accept="image/jpeg, image/png">
        </div>

        <div class="register-detail">
            <h2 class="register-detail-head">商品の詳細</h2>
            <div class="register-detail-category">
                <h3>カテゴリー</h3>
            </div>
            <div class="register-detail-condition">
                <h3>商品の状態</h3>
                <select name="condition">
                    @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="register-detail">
            <div class="register-detail-contents">
                <h3>商品名</h3>
                <input type="text" name="name">
            </div>
            <div class="register-detail-contents">
                <h3>ブランド名</h3>
                <input type="text" name="brand">
            </div>
            <div class="register-detail-contents">
                <h3>商品の説明</h3>
                <input type="text" name="description">
            </div>
            <div class="register-detail-contents">
                <h3>販売価格</h3>
                <input type="text" name="brand">
            </div>
        </div>
        <div class="form-submit">
            <button type="submit" class="submit-button">出品する</button>
        </div>
    </form>
</div>
@endsection