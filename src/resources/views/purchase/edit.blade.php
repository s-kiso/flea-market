@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/edit.css') }}">
@endsection

@section('content')
<div class="edit-contents">
    <div class="edit-heading">
        <h2>住所の変更</h2>
    </div>
    <form action="{{ route('address.modified', ['item_id'=>$item_id]) }}" enctype="multipart/form-data" class="edit-form" method="post">
        @csrf
        <div class="form-item">
            <label class="form-label">郵便番号</label>
            <div class="form-error">
                @error('postal_code')
                {{$message}}
                @enderror
            </div>
            <input type="text" class="form-input" name="postal_code" value="{{ old('postal_code') }}">
        </div>
        <div class="form-item">
            <label class="form-label">住所</label>
            <div class="form-error">
                @error('address')
                {{$message}}
                @enderror
            </div>
            <input type="text" class="form-input" name="address" value="{{ old('address') }}">
        </div>
        <div class="form-item">
            <label class="form-label">建物名</label>
            <div class="form-error">
                @error('building')
                {{$message}}
                @enderror
            </div>
            <input type="text" class="form-input" name="building" value="{{ old('building') }}">
        </div>
        <div class="form-submit">
            <input type="hidden" name="type" value="{{ $type }}">
            <button type="submit" class="form-button">更新する</button>
        </div>
    </form>
</div>
@endsection