<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follow;
use App\Models\Post;
use App\Models\Category;


class FollowController extends Controller
{
    public function follow(Follow $follow, User $user) {
        
        $follow->follower_id = \Auth::user()->id;
        $follow->followee_id = $user->id;
        $follow -> save();
        return back();
    }

    public function unfollow(User $user) {
        $follow = Follow::where('follower_id',\Auth::user()->id)->where('followee_id', $user->id)->first();
        $follow->delete();
        
        return back();
    }
    
    //フォロー中のユーザーの投稿一覧取得　https://newmonz.jp/lesson/laravel-basic/chapter-9　「ブックマークした記事一覧を取得」を参考
    public function follows_posts(Category $category, Post $post){
        $followee = Follow::where('follower_id',\Auth::user()->id)->get();
        
        $post_follow = $post->whereIn('user_id', $followee->pluck('followee_id')->toArray())->orderBy( 'updated_at', 'desc' )->paginate(3);
        $header = $post->inRandomOrder()->first();
    
        return view('posts.followees_posts_index',compact('header'))->with([
            'posts' => $post_follow,
            'categories' => $category->get()
            ]);
    }
}
