<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function index(Post $post){
        return view('posts.index')->with(['posts'=>$post->getPaginate()]);
    }
    
    public function show(Post $post){
        return view('posts.show')->with(['post'=>$post]);
    }
    
    public function create(Category $category){
        return view('posts.create')->with(['categories'=>$category->get()]);
    }
    
    public function store(PostRequest $request,Post $post){

        $post->user_id = \Auth::id();
        $input = $request['post'];
        $post->fill($input)->save();
        return redirect('/posts/'.$post->id); 
        
    }
    
    public function edit(Post $post){
        return view('posts.edit')->with(['post'=>$post]);
    }
    
    public function update(PostRequest $request,Post $post){
        $post->update($request['post']);
        return redirect('/posts/'.$post->id);
    }
    
    public function delete(Post $post){
       
        $post->delete();
        return redirect('/');
    }
}
