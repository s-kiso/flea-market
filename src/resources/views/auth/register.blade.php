@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
<div class="register-contents">
    <div class="register-heading">
        <h2>会員登録</h2>
    </div>
    <form action="/register" class="register-form">
        <div class="form-item">
            <label>ユーザー名</label>
            <input type="text" class="form-input" name="name">
        </div>
        <div class="form-item">
            <label>メールアドレス</label>
            <input type="email" class="form-input" name="email">
        </div>
        <div class="form-item">
            <label>パスワード</label>
            <input type="password" class="form-input" name="password">
        </div>
        <div class="form-item">
            <label>確認用パスワード</label>
            <input type="password" class="form-input" name="check_password">
        </div>
        <div class="form-submit">
            <button type="submit">登録する</button>
        </div>
    </form>
    <div class="login">
        <a href="/login">ログインはこちら</a>
    </div>
</div>
@endsection