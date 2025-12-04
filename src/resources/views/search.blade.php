@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="card-wrap">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>商品一覧</h2>
                <a href="{{ route('products.create') }}" class="btn-primary">+ 商品を追加</a>
            </div>

    <form method="get" action="{{ route('products.search') }}" class="form-inline mb-3">
        <input type="text" name="search" class="form-control mr-2" placeholder="商品名で検索" value="{{ request('search') }}">
        <select name="sort" class="form-control mr-2">
            <option value="">価格で並び替え</option>
            <option value="desc" {{ request('sort')=='desc' ? 'selected' : '' }}>高い順に表示</option>
            <option value="asc" {{ request('sort')=='asc' ? 'selected' : '' }}>低い順位表示</option>
        </select>
    </div>

    <div class="form-group">
        <label class="small text-muted">価格順で表示</label>
        <select name="sort" id="sortSelect" class="form-control">
            <option value="">価格で並び替え<option>
            <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>高い順に表示</option>
            <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>低い順に表示</option>
        </select>
        <button type="submit" class="btn-primary mr-2">検索</button>
        <a href="{{ route('products.index') }}" class="btn-secondary">×</a>
    </form>

    <div class="row">
        @foreach($products as $p)
        <div class="col-md-4 mb-4">
            <div class="card p-2">
                <div class="img-box mb-2">
                @if($p->image)
                <img src="{{ asset($p->image) }}" alt="{{ $p->name }}" style="width:200px; height:180px; object-fit:cover;">
                @else
                <div style="width:200px; height:180px;display:flex;align-items:center;justify-content:center;color:#999;">No Image</div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
        </div>

        <div class="text-center">
            {{ $products->links('vendor.pagination.simple-default') }}
        </div>
    </main>
    </div>
    </div>

@endsection
