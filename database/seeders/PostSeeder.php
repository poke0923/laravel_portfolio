<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'title'=>'ポケモン',
            'body'=>'ダウンロードコンテンツがもうすぐ発売です！',
            'category_id'=>1,
            'user_id'=>1,
            ]);
        
        DB::table('posts')->insert([
            'title'=>'イチョウ',
            'body'=>'この前イチョウ並木を見てきました。圧巻！！',
            'category_id'=>2,
            'user_id'=>1,
            ]);
        DB::table('posts')->insert([
            'title'=>'ひまわり',
            'body'=>'夏のひまわり畑が素敵でした',
            'category_id'=>3,
            'user_id'=>1,
            ]);
        DB::table('posts')->insert([
            'title'=>'さくら',
            'body'=>'千葉公園の桜がとてもきれいでした',
            'category_id'=>2,
            'user_id'=>1,
            ]);
        DB::table('posts')->insert([
            'title'=>'イルミネーション',
            'body'=>'六本木に初上陸。イルミネーションにみんな見とれていました。',
            'category_id'=>3,
            'user_id'=>1,
            ]);
        
    }
}
