<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DBからテーブルを呼び出してinsertする
        //https://readouble.com/laravel/9.x/ja/seeding.html?header=%25E3%2582%25B7%25E3%2583%25BC%25E3%2583%2580%25E3%2582%25AF%25E3%2583%25A9%25E3%2582%25B9%25E5%25AE%259A%25E7%25BE%25A9
        DB::table('categories')->insert([
            'name' => '動物'     
        ]);
        DB::table('categories')->insert([
            'name' => '乗り物'     
        ]);
        DB::table('categories')->insert([
            'name' => '自然'     
        ]);
        DB::table('categories')->insert([
            'name' => '建物'     
        ]);
        DB::table('categories')->insert([
            'name' => '街中'     
        ]);
        
        
    }
}
