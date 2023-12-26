<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;

class TagController extends Controller
{
    //タグ毎の投稿一覧取得
    public function index(Category $category,Tag $tag){
        $post = $tag->posts()->orderBy( 'updated_at', 'desc' )->paginate(3);
        return view('tags.index',compact('tag'))->with([
            'posts' => $post,
            'categories' => $category->get()
            ]);
    }
}
