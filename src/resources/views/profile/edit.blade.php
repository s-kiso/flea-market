@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile/edit.css') }}">
@endsection

@section('content')
<div class="edit-contents">
    <div class="edit-heading">
        <h2>プロフィール設定</h2>
    </div>
    <form action="/edit" enctype="multipart/form-data" class="edit-form" method="post">
        @csrf
        <div class="form-item-image">
            <input type="file" class="form-file" name="image">
            <div class="form-error">
                @error('image')
                {{$message}}
                @enderror
            </div>
        </div>
        
        <div class="form-item">
            <label class="form-label">ユーザー名</label>
            <input type="text" class="form-input" name="name" value="{{ Auth::user()->name }}">
            <div class="form-error">
                @error('name')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="form-item">
            <label class="form-label">郵便番号</label>
            <input type="text" class="form-input" name="postal_code" value="{{ old('postal_code') }}">
        </div>
        <div class="form-item">
            <label class="form-label">住所</label>
            <input type="text" class="form-input" name="address" value="{{ old('address') }}">
        </div>
        <div class="form-item">
            <label class="form-label">建物名</label>
            <input type="text" class="form-input" name="building" value="{{ old('building') }}">
        </div>
        <div class="form-submit">
            <button type="submit" class="form-button">更新する</button>
        </div>
    </form>
</div>
@endsection