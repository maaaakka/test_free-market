<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(Request $request)
    {
        // 新規postを作成
        $post=new Post();

        // バリデーションルール
        $inputs=request()->validate([
            'title'=>'required|max:255',
            'body'=>'required|max:255',
            'image'=>'image'
        ]);

        // 画像ファイルの保存場所指定
        if(request('image')){
            $filename=request()->file('image')->getClientOriginalName();
            $inputs['image']=request('image')->storeAs('public/images', $filename);
        }

        // postを保存
        $post->create($inputs);
}

}