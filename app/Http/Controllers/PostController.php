<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Tag;

class PostController extends Controller
{
    //投稿一覧表示
    public function index(Request $request, Post $post, Category $category, Tag $tag){
        //Requestのパラメータを取得
        
        $keyword = $request->input('keyword');
        $categoryId = $request->input('category_id');
        $tagsId = $request->input('tag');
        $pagination = 3;
        
      
        return view('posts.index')->with([
            'posts' => $post->search($keyword,$categoryId,$tagsId,$pagination), //メソッドの引数に入れてあげればModelで引き継げる　https://qiita.com/satorunooshie/items/c4b8fa611d9de632381f
            'categories' => $category->get(),
            'tags' => $tag->get(),
        ]);
    }
    
    //投稿詳細表示
    public function show(Post $post){
        
        $favorite=Favorite::where('post_id', $post->id)->where('user_id', auth()->user()->id)->exists();
        
        return view('posts.show', compact('favorite'))->with(['post'=>$post]);
    }
    
    //新規投稿作成
    public function create(Category $category, Tag $tag){
        return view('posts.create')->with([
            'categories' => $category->get(),
            'tags' => $tag->get(),
        ]);
    }
    
    //新規投稿保存
    public function store(PostRequest $request, Post $post){

        $post->user_id = \Auth::id();
        //https://newmonz.jp/lesson/laravel-basic/chapter-8
        //このサイトのユーザーid保存の項目の1行を追加。
        
        $input = $request['post'];
        $post->fill($input)->save();
        
        $postTag = $request['tag'];
        $post->tags()->attach($postTag);
        //fillはあくまでカラムの内容を更新するだけ。
        //user_idについてはその前の行で追加しているからsaveまでいける。
        return redirect('/posts/'.$post->id); 
        
    }
    
    //投稿編集
    public function edit(Category $category,Post $post,Tag $tag){
        
        return view('posts.edit')->with([
            'post' => $post,
            'categories' => $category->get(),
            'tags' => $tag->get(),
        ]);
    }
    
    //投稿編集保存
    public function update(PostRequest $request,Post $post){
        $post->update($request['post']);
        $postTag = $request['tag'];
        $post->tags()->sync($postTag);
        return redirect('/posts/'.$post->id);
    }
    
    //投稿削除
    public function delete(Post $post){
       
        $post->delete();
        return redirect('/');
    }
    
    //お気に入り数順での投稿取得
    public function favorite_rank(Post $post,Category  $category){
        return view('favorites.rank')->with([
            'posts' => $post->favorite_rank(),
            'categories' => $category->get(),
            ]);
    }
    
}
