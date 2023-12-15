<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;

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

Route::get('/',[PostController::class,'index'])->name('index')->middleware('auth');
//最後にmiddlewareを入れることでログイン済みでないとログイン画面に戻る　https://naoya-ono.com/blog/laravel-auth/

Route::controller(PostController::class)->middleware('auth')->group(function(){
    Route::get('/','index')->name('index');
    Route::get('/posts/create','create')->name('create');
    Route::get('/posts/{post}','show')->name('show');
    Route::post('/posts','store')->name('store');
    Route::get('/posts/{post}/edit','edit')->name('edit');
    Route::put('/posts/{post}/edit','update')->name('update');
    //データの取得と送信の双方でのやり取りがあるputの時はURLをgetと同じにする必要がある？
    Route::delete('/posts/{post}/delete','delete')->name('delete');
});
//ルートをまとめることはこのサイト https://nextat.co.jp/staff/archives/279
//間にmiddleware('auth')を挟むと認証済みかどうかも組み込める

Route::get('/categories/{category}',[CategoryController::class,'index'])->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
