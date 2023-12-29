<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Favorite;
use App\Models\Category;

class FavoriteController extends Controller
{
    //お気に入り追加
    public function favorite(Favorite $favorite, Post $post, Request $request){
        
        $favorite->post_id = $post->id;
        $favorite->user_id = \Auth::user()->id;
        $favorite->save();
        return back();
    }
    
    //お気に入り削除
    public function unfavorite(Post $post, Request $request){
        $user = \Auth::user()->id;
        $favorite = Favorite::where( 'post_id', $post->id )->where( 'user_id', $user )->first();
        $favorite -> delete();
        return back();
    }
    
    //お気に入りした投稿一覧取得　https://newmonz.jp/lesson/laravel-basic/chapter-9　「ブックマークした記事一覧を取得」を参考
    public function favorite_posts(Post $post,Category $category){
    
        return view('favorites.index')->with([
            'posts' => $post->favorite_posts(),
            'categories' => $category->get()
            ]);
    }
    
}
