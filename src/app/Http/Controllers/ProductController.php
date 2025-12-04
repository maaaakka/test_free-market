<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 商品一覧
    public function index(Request $request)
    {
        $query = Product::query()->with('seasons');

        // 検索
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 並び替え
        if ($request->sort === 'asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('id', 'asc');
        }

        $products = $query->paginate(6)->withQueryString();

        return view('products', compact('products'));
    }

    // 詳細（更新画面と同じ）
    public function detail(Product $product)
    {
        $seasons = Season::all();
        $product->load('seasons');

        return view('detail', compact('product', 'seasons'));
    }

    // 検索専用ページ
    public function search(Request $request)
    {
        $query = Product::query()->with('seasons');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->sort === 'asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'desc') {
            $query->orderBy('price', 'desc');
        }

        $products = $query->paginate(6)->withQueryString();

        return view('search', compact('products'));
    }

    // 登録ページ
    public function create()
    {
        $seasons = Season::all();
        return view('register', compact('seasons'));
    }

    // 登録処理
    public function store(ProductRequest $request)
    {
        $data = $request->only(['name', 'price', 'detail']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = 'storage/' . $path;
        }

        $product = Product::create($data);

        $product->seasons()->sync($request->input('seasons', []));

        return redirect()->route('products.index');
    }

    // 更新画面
    public function edit(Product $product)
    {
        $seasons = Season::all();
        $product->load('seasons');

        return view('update', compact('product', 'seasons'));
    }

    // 更新処理
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->only(['name', 'price', 'detail']);

        if ($request->hasFile('image')) {

            if ($product->image && preg_match('#^storage/(.+)$#', $product->image, $m)) {
                Storage::disk('public')->delete($m[1]);
            }

            $path = $request->file('image')->store('images', 'public');
            $data['image'] = 'storage/' . $path;
        }

        $product->update($data);
        $product->seasons()->sync($request->input('seasons', []));

        return redirect()->route('products.index');
    }

    // 削除処理
    public function destroy(Product $product)
    {
        if ($product->image && preg_match('#^storage/(.+)$#', $product->image, $m)) {
            Storage::disk('public')->delete($m[1]);
        }

        $product->seasons()->detach();
        $product->delete();

        return redirect()->route('products.index');
    }
}