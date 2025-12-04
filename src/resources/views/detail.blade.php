@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')

<div class="container">
<div class="detail-card">
    <div class="breadcrumb">
    <a href="{{ route('products.index') }}">商品一覧</a> &gt; {{ $product->name }}</div>

<form action="{{ route('products.update', $product->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
    <div class="col-md-5">
        <div class="image-preview">
        <img id="previewImg" src="{{ asset($product->image) }}" alt="商品画像">
        </div>

    <div class="mt-2">
        <label class="file-btn">
            ファイルを選択
            <input type="file" name="image" accept=".png,.jpeg">
        </label>
            <span class="filename">{{ $product->image ? basename($product->image) : '' }}</span>
            @error('image')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            </div>
    </div>

    <div class="col-md-7”>
    <div class="form-group">
        <label>商品名</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
        @error('name')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label>値段</label>
            <input type="number" name="price" value="{{ old('price', $product->price) }}" class="form-control" min="0" max="10000">
            @error('price')
            <div class="text-danger">{{ $message }}</div>
            @enderror
    </div>
    <div class="form-group">
        <label>季節</label>
        <div class="season-list">
            @foreach($season as $season)
            <label class="round-checkbox">
                <input type="checkbox" name="seasons[]" value="{{ $season->id ) }}"
                {{ in_array($season->id, old('seasons', $product->seasons->pluck('id')->toArray())) ? 'checked' : '' }}>
                <span class="circle"></span>
                <span class="season-label">{{ $season->name}}</span>
            </label>
            @endforeach
        </div>
            @error('seasons')
            <div class="text-danger">{{ $message }}</div>
            @enderror
    </div>
    <div class="form-group">
        <label>商品説明</label>
            <textarea name="detail" class="form-control" rows="6" {{ old('detail', $product->detail) }}</textarea>
            @error('detail')
            <div class="text-danger">{{ $message }}</div>
            @enderror
    </div>
    </div>
</div>

<div class="form-actions text-center">
    <a href="{{route('products.index') }}" class="btn-secondary">戻る</a>
    <button type="submit" class="btn-primary">変更を保存</button>
    <a href="{{ route('products.delete', $product->id) }}" class="btn-secondary">🗑️</a>
    </div>
    </form>
@endsection