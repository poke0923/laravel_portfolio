<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class CategoryController extends Controller
{
    //カテゴリーごとの投稿取得
    public function index(Post $post, Category $category){
        
        $header = $post->inRandomOrder()->first();
        //view側でカテゴリー選択時にそのカテゴリーのcategory_idが$categoryに格納されている。
        //getCategoryPaginateを使ってデータを取得している
        return view('categories.index',compact('header'))->with(['posts'=>$category->getCategoryPaginate()]);
        
        
    }
}
