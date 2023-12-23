<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TagController extends Controller
{
    //投稿につけられたタグ取得　https://newmonz.jp/lesson/laravel-basic/chapter-9　「ブックマークした記事一覧を取得」を参考
    public function post_tags(Category $category){
        $tag = $post->tags()->get();
    
        return view('favorites.index')->with([
            'posts' => $post,
            'categories' => $category->get()
            ]);
    }
}
