<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    /*
    public function getPaginate($limit=3){
        return $this->orderBy('updated_at','desc')->paginate($limit);
    }
    */
    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function getSerchedPaginate($limit=3){
        
        $query=$this->query();
        
        if(!empty($keyword)) {//$keyword　が空ではない場合、検索処理を実行します
            $query->where('title', 'LIKE', "%{$keyword}%");
        }
        
        return $query->orderBy('updated_at','desc')->paginate($limit);
        
    }
    
    protected $fillable=[
        'title',
        'body',
        'category_id',
        ];
}
