<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;

class TagController extends Controller
{
    //タグ毎の投稿一覧取得
    public function index(Post $post,Category $category,Tag $tag){
        $post_tag = $tag->posts()->orderBy( 'updated_at', 'desc' )->paginate(3);
        $header = $post->inRandomOrder()->first();
        return view('tags.index',compact('tag','header'))->with([
            'posts' => $post_tag,
            'categories' => $category->get()
            ]);
    }
}
