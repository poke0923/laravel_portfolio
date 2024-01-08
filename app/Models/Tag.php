<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    
    public function posts(){
        return $this -> belongsToMany(Post::class);
    }
    
    //タグごとの投稿取得
    public function getTagPaginate(){
        return $this->posts()->with('tags')->orderBy( 'updated_at','desc' )->paginate(9);
    }
}
