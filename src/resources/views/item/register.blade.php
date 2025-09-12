@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/register.css') }}">
@endsection

@section('content')
<div class="register-contents">
    <div class="register-heading">
        <h1>商品の出品</h1>
    </div>

    <form action="/sell" class="register-form" enctype="multipart/form-data" method="post">
    @csrf
        <div class="register-image">
            <h3>商品画像</h3>
            <div class="form-error">
                @error('image')
                {{$message}}
                @enderror
            </div>
            <div class="register-image-input">
                <input type="file" name="image" accept="image/jpeg, image/png">
            </div>
            
        </div>

        <div class="register-detail">
            <h2 class="register-detail-head">商品の詳細</h2>
            <div class="register-detail-category">
                <h3>カテゴリー</h3>
                <div class="form-error">
                    @error('category')
                    {{$message}}
                    @enderror
                </div>
                <div class="category-item">
                    <input type="checkbox" name="category[]" value="1" id="fashion"><label for="fashion">ファッション</label>
                    <input type="checkbox" name="category[]" value="2" id="appliance"><label for="appliance">家電</label>
                    <input type="checkbox" name="category[]" value="3" id="interior"><label for="interior">インテリア</label>
                    <input type="checkbox" name="category[]" value="4" id="ladies"><label for="ladies">レディース</label>
                    <input type="checkbox" name="category[]" value="5" id="mens"><label for="mens">メンズ</label>
                    <input type="checkbox" name="category[]" value="6" id="cosmetics"><label for="cosmetics">コスメ</label>
                    <input type="checkbox" name="category[]" value="7" id="book"><label for="book">本</label>
                    <input type="checkbox" name="category[]" value="8" id="game"><label for="game">ゲーム</label>
                    <input type="checkbox" name="category[]" value="9" id="sports"><label for="sports">スポーツ</label>
                    <input type="checkbox" name="category[]" value="10" id="kitchen"><label for="kitchen">キッチン</label>
                    <input type="checkbox" name="category[]" value="11" id="handmade"><label for="handmade">ハンドメイド</label>
                    <input type="checkbox" name="category[]" value="12" id="accessory"><label for="accessory">アクセサリー</label>
                    <input type="checkbox" name="category[]" value="13" id="toy"><label for="toy">おもちゃ</label>
                    <input type="checkbox" name="category[]" value="14" id="baby"><label for="baby">ベビー・キッズ</label>
                </div>
            </div>
            <div class="register-detail-condition">
                <h3>商品の状態</h3>
                <div class="form-error">
                    @error('condition')
                    {{$message}}
                    @enderror
                </div>
                <select name="condition">
                    <option value="" hidden>選択してください</option>
                    @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="register-description">
            <h2 class="register-description-head">商品名と説明</h2>
            <div class="register-description-contents">
                <h3>商品名</h3>
                <div class="form-error">
                    @error('name')
                    {{$message}}
                    @enderror
                </div>
                <input type="text" name="name">
            </div>
            <div class="register-description-contents">
                <h3>ブランド名</h3>
                <input type="text" name="brand">
            </div>
            <div class="register-description-contents">
                <h3>商品の説明</h3>
                <div class="form-error">
                    @error('description')
                    {{$message}}
                    @enderror
                </div>
                <textarea name="description"></textarea>
            </div>
            <div class="register-description-contents">
                <h3>販売価格</h3>
                <div class="form-error">
                    @error('price')
                    {{$message}}
                    @enderror
                </div>
                <input type="number" name="price">
            </div>
        </div>
        
        <div class="form-submit">
            <button type="submit" class="submit-button">出品する</button>
        </div>
    </form>
</div>
@endsection