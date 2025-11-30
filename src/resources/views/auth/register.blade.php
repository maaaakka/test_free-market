@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

<div class="register-form__content">
    <div class="register-form__heading">
        <h2>商品登録</h2>
    </div>
    <form class="form" action="/register" method="post">
        @csrf
        <div class="register-form__group">
        <label class="register-form__label" for="name">
            商品名<span class="register-form__required">必須</span>
        </label>
        <div class="form__group-content">
            <div class="form__input--text">
            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="商品名を入力"/>
            </div>
            <div class="form__error">
            @error('name')
            {{ $message }}
            @enderror
            </div>
        </div>
        </div>
        <div class="register-form__group">
        <label class="register-form__label" for="price">
            値段<span class="register-form__required">必須</span>
        </label>
        <div class="form__group-content">
            <div class="form__input--text">
            <input type="text" name="price" id="price" value="{{ old('price') }}" placeholder="値段を入力">
            </div>
            <div class="form__error">
            @error('price')
            {{ $message }}
            @enderror
            </div>
        </div>
        </div>
        <div class="register-form__group">
        <label class="register-form__label" for="image">
            商品画像<span class="register-form__required">必須</span>
        </label>
        <div class="form__group-content">
            <div class="form__input--text">
            <input id="image" type="file" name="image" value="{{ old('image') }}" />
            </div>
            <div class="form__error">
            @error('image')
            {{ $message }}
            @enderror
            </div>
        </div>
        </div>
        <div class="register-form__group">
        <label class="register-form__label" for="">
            季節<span class="register-form__required">必須</span>
        </label>
        <div class="form__group-content">
            <div class="form__input--checkbox">
            <input type="checkbox" name="seasons" value="{{ old('seasons') }}" />
            </div>
            <div class="form__error">
            @error('seasons')
            {{ $message }}
            @enderror
            </div>
        </div>
        </div>
        <div class="register-form__group">
        <label class="register-form__label" for="detail">
            商品説明<span class="register-form__required">必須</span>
        </label>
        <textarea class="form-group__textarea"  name="detail" id="" cols="30" rows="10" placeholder="商品の説明を入力">{{ old('detail') }}</textarea>
            <div class="form__error">
            @error('detail')
            {{ $message }}
            @enderror
            </div>
        </div>
        <div class="return__link">
        <a class="return__button-submit" href="/products">戻る</a>
    </div>
</div>
        <div class="form__button">
        <button class="form__button-submit" type="submit">登録</button>
        </div>
    </form>
@endsection
