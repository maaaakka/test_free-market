@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

<div class="container">
    <div class="card-wrap">
        <h2>商品登録</h2>
    </div>
    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
        <label>商品名</label>
        <span class="required"> 必須</span>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力" class="form-control">
            @error('name')
            <div class="text-danger">
            {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
        <label>値段</label>
        <span class="required"> 必須</span>
            <input type="number" name="price" value="{{ old('price') }}" placeholder="値段を入力" class="form-control">
            @error('price')
            <div class="text-danger">
            {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
        <label>商品画像</label>
        <span class="required"> 必須</span><br>
        <label class="file-btn">ファイルを選択
        <input type="file" name="image" accept=".png,.jpeg"></label>
            @error('image')
            <div class="text-danger">
            {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
        <label>季節</label>
        <span class="required"> 必須 </span>
        <span class="second-required"> 複数選択可</span>
            <div class="season-list">
            @foreach($season as $season)
            <label class="round-checkbox">
                <input type="checkbox" name="seasons[]" value="{{ $season->id }}" {{ in_array($season->id, old('seasons', [])) ? 'checked' : '' }}>
                <span class="circle"></span>
                <span class="season-label">{{ $season->name }}</span>
            </label>
            @error('seasons')
            <div class="text-danger">
            {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
        <label>商品名</label>
        <span class="required"> 必須</span>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力" class="form-control">
            @error('name')
            <div class="text-danger">
            {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
        <label>商品説明</label>
        <span class="required"> 必須</span>
            <textarea name="detail" class="form-control" rows="6" placeholder="商品の説明を入力">{{ old('detail') }}</textarea>
            @error('detail')
            <div class="text-danger">
            {{ $message }}
            </div>
            @enderror
        </div>

    <div class="text-center">
        <a href="{{ route('products.index') }}" class="btn-secondary">戻る</a>
        <button type="submit" class="btn-primary">登録</button>
    </div>
    </form>
</div>
@endsection
