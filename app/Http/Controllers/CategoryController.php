<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function index(Category $category){
        //$categoryにすでに指定したカテゴリーのcategory_idが格納されている。
        //$categoryで指定したidについてgetCategoryPaginateを使ってデータを取得している
        return view('categories.index')->with(['posts'=>$category->getCategoryPaginate()]);
        
        
    }
}
