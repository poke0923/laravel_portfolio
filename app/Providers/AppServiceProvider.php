<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
        \URL::forceScheme('https');  //すべての接続をhttpsにする。これはクラウド上だから必要という感じらしい。20:40くらい～説明されてる。https://www.youtube.com/watch?v=BQBNJ-wArLo&t=177s
        $this->app['request']->server->set('HTTPS','on');
        //これはぺジネーションにも対応させるときに必要らしいが、調べても出てこない。よくわからん。
        //https://qiita.com/takuma-jpn/items/712a3ec7abcd045a087d とりあえずここに載ってる。
        
    }
}
