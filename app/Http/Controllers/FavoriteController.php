<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    //お気に入り追加
    public function favorite(Favorite $favorite, Post $post, Request $request){
        
        $favorite -> post_id = $post -> id;
        $favorite -> user_id=\Auth::user() -> id;
        $favorite -> save();
        return back();
    }
    
    //お気に入り削除
    public function unfavorite(Post $post, Request $request){
        $user=\Auth::user()->id;
        $favorite=Favorite::where('post_id', $post->id)->where('user_id', $user)->first();
        $favorite->delete();
        return back();
    }
}
