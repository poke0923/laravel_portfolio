<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public function posts(){
        return $this->hasMany(Post::class);
    }
    
    public function getCategoryPaginate(){
        return $this->posts()->with('category')->orderBy('updated_at','desc')->paginate(6);
        //基本的な形は$this->posts()->paginate();
        //with('category')はEagerロードと呼ばれ、データベースへのアクセスを1回で済ませてくれる手法
        /*
        リレーション先のデータを取り出すコードの書き方の手順は
        1. 基本的な形を作る　$this->posts()->paginate($limit);　※limitのところは数字でOK
           posts()を呼び出すとPostクラスにつながるから、そこからペジネートしてデータを取得する
           この時、どのcategory_idのデータを取り出すかは
           CategoryContorollerでインスタンス化する$categoryにルーティングの時点で暗黙の結合により引き継がれている
        2. orderByで取り出す順番を指定　$this->posts()->orderBy(~)->paginate();
        3. with('category')をposts()の後に入れて、categoryからまとめてデータを取得して、それをorderByにより並べ替える。
           こうすることでデータの取得を一度で済ませることができる。
           $this->posts()->with('category')->orderBy('updated_at','desc')->paginate($limit);
        */
    }
    

}
