<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\FollowController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[PostController::class,'index']) -> name('index') -> middleware('auth');
//最後にmiddlewareを入れることでログイン済みでないとログイン画面に戻る　https://naoya-ono.com/blog/laravel-auth/

Route::controller(PostController::class)->middleware('auth')->group(function(){
    Route::get('/','index')->name('index'); //一覧画面
    Route::get('/posts/create','create')->name('create'); //新規投稿作成
    Route::get('/posts/{post}','show')->name('show'); //投稿詳細
    Route::post('/posts','store')->name('store'); //新規投稿保存
    Route::get('/posts/{post}/edit','edit')->name('edit'); //投稿編集
    Route::put('/posts/{post}/edit','update')->name('update'); //投稿編集保存
    //データの取得と送信の双方でのやり取りがあるputの時はURLをgetと同じにする必要がある？
    Route::delete('/posts/{post}/delete','delete')->name('delete'); //投稿削除
    Route::get('/favorite/posts/rank','favorite_rank')->name('favorite_rank');
});
//ルートをまとめることはこのサイト https://nextat.co.jp/staff/archives/279
//間にmiddleware('auth')を挟むと認証済みかどうかも組み込める

Route::get('/categories/{category}',[CategoryController::class,'index'])->middleware('auth'); //カテゴリー別投稿一覧

//お気に入り機能
Route::controller(FavoriteController::class)->middleware( 'auth' )->group( function(){
    Route::get('/posts/{post}/favorite','favorite')->name('favorite');
    Route::get('/posts/{post}/unfavorite','unfavorite')->name('unfavorite');
    Route::get('/favorites','favorite_posts')->name('index_favorites');
});

Route::get('/tags/{tag}',[TagController::class,'index'])->middleware('auth');

Route::controller(FollowController::class)->middleware( 'auth' )->group( function(){
    Route::get('/follows/{user}/follow','follow')->name('follow');
    Route::get('/follows/{user}/unfollow','unfollow')->name('unfollow');
    Route::get('/follows/posts','follows_posts')->name('index_follows');
});




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(ProfileController::class)->middleware('auth')->group(function () {
    Route::get('/profile', 'edit')->name('profile.edit');
    Route::patch('/profile', 'update')->name('profile.update');
    Route::delete('/profile', 'destroy')->name('profile.destroy');
    Route::get('/profile/{user}', 'profile')->name('profile');
});

require __DIR__.'/auth.php';
