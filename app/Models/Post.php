<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    
    public function getPaginate($limit=3){
        return $this->orderBy('updated_at','desc')->paginate($limit);
    }
    
    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function favorites(){
        return $this -> hasMany(Favorite::class);
    }
    
    public static function search($keyword, $categoryId, $pagination)
    {
        //投稿データを全件取得
        $query = self::query();
        
        //投稿検索(キーワード)
        if (!empty($keyword)) {
            $query->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('body', 'LIKE', "%{$keyword}%");
        }
        // https://qiita.com/hinako_n/items/7729aa9fec522c517f2a
        
        //投稿検索（カテゴリー）
        if (!empty($categoryId)) {
            $query->where('category_id', 'LIKE', $categoryId);
        }
        // https://qiita.com/hinako_n/items/96584b4a641097c753c7
        
        return $query->orderBy('updated_at', 'desc')->paginate($pagination);
    }
    
    //お気に入り状態の判別 https://qiita.com/phper_sugiyama/items/9a4088d1ca816a7e3f29
    public function is_favorited(){
        $id = \Auth::id();

        $favoriters = array();
        foreach($this->favorites as $favorite) { //$this->favoritesでfavoritesテーブルからpost_idで絞り込みされた配列が取り出されている？
            array_push($favoriters, $favorite->user_id);
        }
        
        if (in_array($id, $favoriters)) {
            return true;
        } else {
            return false;
        }
    }
    
    protected $fillable=[
        'title',
        'body',
        'category_id',
        ];
}
