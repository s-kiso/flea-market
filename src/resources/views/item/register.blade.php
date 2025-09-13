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
            <div class="register-image-input">
                <input type="file" name="image" accept="image/jpeg, image/png">
            </div>
            <div class="form-error">
                @error('image')
                {{$message}}
                @enderror
            </div>
        </div>

        <div class="register-detail">
            <h2 class="register-detail-head">商品の詳細</h2>
            <div class="register-detail-category">
                <h3>カテゴリー</h3>
                    <div class="category-item">
                        @foreach($categories as $key => $category)
                            <input type="checkbox" name="category[{{ $key }}]" id="category[{{ $key }}]" value="{{ $category->id }}" @if(old("category.$key") === strval($category->id)) checked @endif>
                            <label for="category[{{ $key }}]">{{ $category->name }}</label>
                        @endforeach
                    </div>
            </div>
            <div class="form-error">
                @error('category')
                {{$message}}
                @enderror
            </div>
            <div class="register-detail-condition">
                <h3>商品の状態</h3>
                <select name="condition">
                    <option value="" hidden>選択してください</option>
                    @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}" @if($condition->id == old('condition')) selected @endif>{{ $condition->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-error">
                @error('condition')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="register-description">
            <h2 class="register-description-head">商品名と説明</h2>
            <div class="register-description-contents">
                <h3>商品名</h3>
                <input type="text" name="name" value="{{ old('name') }}">
                <div class="form-error">
                    @error('name')
                    {{$message}}
                    @enderror
                </div>
            </div>
            <div class="register-description-contents">
                <h3>ブランド名</h3>
                <input type="text" name="brand" value="{{ old('brand') }}">
            </div>
            <div class="register-description-contents">
                <h3>商品の説明</h3>
                <textarea name="description">{{ old('description') }}</textarea>
                <div class="form-error">
                    @error('description')
                    {{$message}}
                    @enderror
                </div>
            </div>
            <div class="register-description-contents">
                <h3>販売価格</h3>
                <input type="number" name="price" value="{{ old('price') }}">
                <div class="form-error">
                    @error('price')
                    {{$message}}
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="form-submit">
            <button type="submit" class="submit-button">出品する</button>
        </div>
    </form>
</div>
@endsection