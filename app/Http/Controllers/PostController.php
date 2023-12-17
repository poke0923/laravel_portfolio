<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    //投稿一覧表示
    public function index(Request $request,Post $post){
        
        /* キーワードから検索処理 */
        $keyword = $request->input('keyword');
        
        $query=$post->query();
        
        if(!empty($keyword)) {//$keyword　が空ではない場合、検索処理を実行します
            $query->where('title', 'LIKE', "%{$keyword}%")->orWhere('body', 'LIKE', "%{$keyword}%");
        }
        
        $serched_posts=$query->orderBy('updated_at','desc')->paginate(3);
        
        return view('posts.index', ['posts' => $serched_posts]);
    }
    
    //投稿詳細表示
    public function show(Post $post){
        return view('posts.show')->with(['post'=>$post]);
    }
    
    //新規投稿作成
    public function create(Category $category){
        return view('posts.create')->with(['categories'=>$category->get()]);
    }
    
    //新規投稿保存
    public function store(PostRequest $request,Post $post){

        $post->user_id = \Auth::id();
        //https://newmonz.jp/lesson/laravel-basic/chapter-8
        //このサイトのユーザーid保存の項目の1行を追加。
        $input = $request['post'];
        $post->fill($input)->save();
        //fillはあくまでカラムの内容を更新するだけ。
        //user_idについてはその前の行で追加しているからsaveまでいける。
        return redirect('/posts/'.$post->id); 
        
    }
    
    //投稿編集
    public function edit(Category $category,Post $post){
        return view('posts.edit')->with(['post'=>$post])->with(['categories'=>$category->get()]);
    }
    
    //投稿編集保存
    public function update(PostRequest $request,Post $post){
        $post->update($request['post']);
        return redirect('/posts/'.$post->id);
    }
    
    //投稿削除
    public function delete(Post $post){
       
        $post->delete();
        return redirect('/');
    }
    
    
}
