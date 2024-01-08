<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public function category(){
        return $this -> belongsTo(Category::class);
    }
    
    public function user(){
        return $this -> belongsTo(User::class);
    }
    
    public function users(){
        return $this -> belongsToMany(User::class,'favorites');
    }
    
    public function favorites(){
        return $this -> hasMany(Favorite::class);
    }
    
    public function tags(){
        return $this -> belongsToMany(Tag::class);
    }
    
    private $paginate=9;
    
    public function search($keyword, $categoryId,$tagsId, $pagination)
    {
        //投稿データに対してのクエリ実行の準備
        $query = self::query();
        
        //キーワード検索 https://qiita.com/hinako_n/items/7729aa9fec522c517f2a
        if (!empty($keyword)) {
            $query->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('body', 'LIKE', "%{$keyword}%");
        }
        
        //カテゴリー検索 https://qiita.com/hinako_n/items/96584b4a641097c753c7
        if (!empty($categoryId)) {
            $query->where('category_id', '=', $categoryId);
        }
        
        //タグ検索
        if (!empty($tagsId)) {
            $query->whereHas('tags',function($q)use($tagsId){
                $q->whereIn('post_tag.tag_id',$tagsId);
            });
        }
        
        return $query->with(['category','tags','favorites'])->orderBy('updated_at', 'desc')->paginate($pagination);
    }
    
    //その投稿のお気に入り状態の判別 https://qiita.com/phper_sugiyama/items/9a4088d1ca816a7e3f29
    public function is_favorited($post){
        //ここの場合はFavoriteモデルをインスタンス化せずに検索をしている。
        //show.bladeから受け取った投稿のidとログイン中のユーザーid両方に一致するレコードを検索してtrueかfalseを返している。
        return $favorite = Favorite::where('post_id', $post->id)->where('user_id', auth()->user()->id)->exists();
    }
    
    //お気に入りの投稿を取得
    public function favorite_posts(){
        //リレーションで設定したfavorite_postsのメソッドを経由してuser_idに紐づくpost_idを取得している
        return \Auth::user()->favorite_posts()->with(['category','tags','favorites'])->orderBy( 'updated_at', 'desc' )->paginate($this->paginate);
    }
    
    //お気に入り数の多い投稿順に取得
    public function favorite_rank(){
        $post = $this->withcount('favorites')->orderBy('favorites_count','desc')->paginate($this->paginate);
        
        return $post;
    }
    
    //投稿ごとのタグ取得（多対多のリレーションのため、一度投稿ごとにこのメソッドを呼び出してタグを取得してviewに返している。）
    public function post_tags($post){
        $tags = $post->tags()->get();
        return $tags;
        
    }
    
    //フォロー状態の判別
    public function is_followed($post){
        return $follow = Follow::where('follower_id', \Auth::user()->id)->where('followee_id', $post->user->id)->exists();
    }
    
    //フォロワー数のカウント
    public function follow_count($post){
        return $count = Follow::where('followee_id', $post->user_id)->count();
    }
    
    protected $fillable=[
        'title',
        'body',
        'category_id',
        'latitude',
        'longitude',
        ];
}
