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
    
    protected $fillable=[
        'title',
        'body',
        'category_id',
        ];
}
