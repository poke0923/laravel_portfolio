<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\EditRequest;
use App\Models\Post;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    //投稿一覧表示
    public function index(Request $request, Post $post, Category $category, Tag $tag){
        //Requestのパラメータを取得
        $keyword = $request->input('keyword');
        $categoryId = $request->input('category_id');
        $tagsId = $request->input('tag');
        $pagination = 9;
        $header = $post->inRandomOrder()->first(); //headerとして使用する画像を全件の投稿からランダムで、firstで最初の一つだけ取得。
        
        //モデルでserchメソッドを実行
        //メソッドの引数に入れてあげればModelで引き継げる　https://qiita.com/satorunooshie/items/c4b8fa611d9de632381f
        $post = $post->search($keyword,$categoryId,$tagsId,$pagination); 
        
        //検索結果保持の際にtagsIdがnullの場合は空の集合に書き換え
        if($tagsId == null){
            $tagsId = [];
        }
        
        //検索結果を保持するための仕組み。view側で呼び出すことができる。
        session([
            'serch_keyword' => $keyword,
            'serch_categoryId' => $categoryId,
            'serch_tagsId' => $tagsId,
            ]);
            
        
        
        return view('posts.index', compact('header') )->with([
            'posts' => $post,
            'categories' => $category->get(),
            'tags_spot' => $tag->where('group','spot')->get(),
            'tags_nature' => $tag->where('group','nature')->get(),
            'tags_animal' => $tag->where('group','animal')->get(),
        ]);
    }
    
    public function serch(Category $category, Tag $tag){
        return view('posts.serch')->with([
            'categories' => $category->get(),
            'tags_spot' => $tag->where('group','spot')->get(),
            'tags_nature' => $tag->where('group','nature')->get(),
            'tags_animal' => $tag->where('group','animal')->get(),
        ]);
    }
    
    //投稿詳細表示
    public function show(Post $post){
        return view('posts.show')->with(['post'=>$post]);
    }
    
    //新規投稿作成
    public function create(Category $category, Tag $tag){
        return view('posts.create')->with([
            'categories' => $category->get(),
            'tags_spot' => $tag->where('group','spot')->get(),
            'tags_nature' => $tag->where('group','nature')->get(),
            'tags_animal' => $tag->where('group','animal')->get(),
        ]);
    }
    
    //新規投稿保存
    public function store(PostRequest $request, Post $post){

        //s3アップロード開始
        if($request->file('image') !== null){
            $image = $request->file('image'); //requestからfileの内容を取得
            $path = Storage::disk('s3')->putFile('/', $image); // バケットへアップロードしてそのパスを取得
            $post->image_path = Storage::disk('s3')->url($path); // アップロードした画像のフルパス(URL)を取得してimage_pathにinput
        }else{
            $post->image_path = $request->input('post.image_path');
        }
        
        //保存した画像パスをセッションに保存
        $request->session()->flash('image', $post->image_path);
        
        //画像保存処理をしていないときとしているときでバリデーションを分ける
        //これをしないと画像以外のバリデーションで戻されたときにファイル選択しなおす必要がある。
        if($post->image_path === null){
            $validated = $request->validate([
                'post.title' => 'required|max:50',
                'post.body' => 'max:200',
                'image' => 'required',
            ],
            [
                'image' => '写真を選択してください。',
                'post.title.required' => 'タイトルは必ず入力してください。',
                'post.title.max' => 'タイトルは50文字以内で入力してください。',
                'post.body.max' => '写真説明は200文字以内で入力してください。',
                
            ]); 
        }else{
            $validated = $request->validate([
                'post.title' => 'required|max:50',
                'post.body' => 'max:200',
            ],
            [
                'post.title.required' => 'タイトルは必ず入力してください。',
                'post.title.max' => 'タイトルは50文字以内で入力してください。',
                'post.body.max' => '写真説明は200文字以内で入力してください。',
                
            ]); 
        }
        //ログイン中のユーザーIDをinput　https://newmonz.jp/lesson/laravel-basic/chapter-8
        $post->user_id = \Auth::id();
        
        //その他、新規投稿で入力された内容のうちpostと名のついたものをを各カラムにinput
        $input = $request['post'];
        $post->fill($input)->save(); //fillはあくまでカラムの内容を更新するだけ。
        
        //タグの保存は多対多のリレーションが関係するため別のメソッドを使用。
        //すでに投稿は保存したのでpost_idが存在しているため、こちらも保存可能？
        $postTag = $request['tag'];
        $post->tags()->attach($postTag);
        
        return redirect('/posts/'.$post->id); 
    }
    
    //投稿編集（暗黙の結合により$postには元の投稿の内容が入っている）
    public function edit(Category $category,Post $post,Tag $tag){
        
        return view('posts.edit')->with([
            'post' => $post,
            'categories' => $category->get(),
            'tags_spot' => $tag->where('group','spot')->get(),
            'tags_nature' => $tag->where('group','nature')->get(),
            'tags_animal' => $tag->where('group','animal')->get(),
        ]);
    }
    
    // 投稿編集保存
    public function update(EditRequest $request,Post $post){
        // 変更前のimageのパスを取得。新しい画像しかパスが残らない。
        $preImagePath = $post->image_path;
        $request->session()->flash('preImage', $preImagePath);
        
        $newImagePath = null; // 新規画像パスを保存するための変数
        //s3アップロード開始（新規投稿と同じ処理）
        if($request->file('image') !== null){
            $image = $request->file('image');
            $path = Storage::disk('s3')->putFile('/', $image);
            $newImagePath = Storage::disk('s3')->url($path);
            $post->image_path = $newImagePath;
            
        }elseif($request->input('post.new_image_path') !== null ){ // imageの変更後にバリエラーで戻される → もう一度他項目を修正して保存　の時に$post->image_pathに一度保存したパスを入れている
            $newImagePath = $request->input('post.new_image_path');
            $post->image_path = $newImagePath;
            
        }
        //元の画像と今image_pathにあるパスが違うときはセッションに新しい画像のパスを保存 (newImagePath !== null を付けないとpreImageには絶対にパスが入っているので、毎回nullに更新されてしまう。)
        if($newImagePath !== null && $preImagePath != $newImagePath){
            $request->session()->flash('newImage', $newImagePath);
            
        }
        
        $validated = $request->validate([
                'post.title' => 'required|max:50',
                'post.body' => 'max:200',
            ],
            [
                'post.title.required' => 'タイトルは必ず入力してください。',
                'post.title.max' => 'タイトルは50文字以内で入力してください。',
                'post.body.max' => '写真説明は200文字以内で入力してください。',
                
            ]); 
        
        
        //updateで更新処理
        $post->update($request['post']);
        
        //タグは多対多のリレーションの更新。更新ではsyncのメソッドを使用すればよい
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
        $header = $post->inRandomOrder()->first();
        return view('favorites.rank',compact('header'))->with([
            'posts' => $post->favorite_rank(),
            'categories' => $category->get(),
            ]);
    }
    

    
}
