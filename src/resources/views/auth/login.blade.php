@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="login-contents">
    <div class="login-heading">
        <h2>ログイン</h2>
    </div>
    <form action="/login" class="login-form" method="post">
    @csrf
        <div class="form-item">
            <label class="form-label">メールアドレス</label>
            <input type="email" class="form-input" name="email">
        </div>
        <div class="form-item">
            <label class="form-label">パスワード</label>
            <input type="password" class="form-input" name="password">
        </div>
        <div class="form-submit">
            <button type="submit" class="form-button">ログインする</button>
        </div>
    </form>
    <div class="register">
        <a href="/register">会員登録はこちら</a>
    </div>
</div>
@endsection