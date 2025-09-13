@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
<div class="register-contents">
    <div class="register-heading">
        <h2>会員登録</h2>
    </div>
    <form action="/register" class="register-form" method="post">
    @csrf
        <div class="form-item">
            <label class="form-label">ユーザー名</label>
            <input type="text" class="form-input" name="name" value="{{ old('name') }}">
            <div class="form-error">
                @error('name')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="form-item">
            <label class="form-label">メールアドレス</label>
            <input type="email" class="form-input" name="email" value="{{ old('email') }}">
            <div class="form-error">
                @error('email')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="form-item">
            <label class="form-label">パスワード</label>
            <input type="password" class="form-input" name="password">
            <div class="form-error">
                @error('password')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="form-item">
            <label class="form-label">確認用パスワード</label>
            <input type="password" class="form-input" name="password_confirmation">
        </div>
        <div class="form-submit">
            <button type="submit" class="form-button">登録する</button>
        </div>
    </form>
    <div class="login">
        <a href="/login">ログインはこちら</a>
    </div>
</div>
@endsection