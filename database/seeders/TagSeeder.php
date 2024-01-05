<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tags')->insert([
            'name' => '北海道',
            'group' => 'spot',
        ]);
        DB::table('tags')->insert([
            'name' => '東北',
            'group' => 'spot',
        ]);
        DB::table('tags')->insert([
            'name' => '関東',
            'group' => 'spot',
        ]);
        DB::table('tags')->insert([
            'name' => '中部',
            'group' => 'spot',
        ]);
        DB::table('tags')->insert([
            'name' => '近畿',
            'group' => 'spot',
        ]);
        DB::table('tags')->insert([
            'name' => '中国',
            'group' => 'spot',
        ]);
        DB::table('tags')->insert([
            'name' => '四国',
            'group' => 'spot',
        ]);
        DB::table('tags')->insert([
            'name' => '九州',
            'group' => 'spot',
        ]);
        DB::table('tags')->insert([
            'name' => '桜',
            'group' => 'nature',
        ]);
        DB::table('tags')->insert([
            'name' => '海',
            'group' => 'nature',
        ]);
        DB::table('tags')->insert([
            'name' => '森',
            'group' => 'nature',
        ]);
        DB::table('tags')->insert([
            'name' => 'いぬ',
            'group' => 'animal',
        ]);
        DB::table('tags')->insert([
            'name' => 'ねこ',
            'group' => 'animal',
        ]);
        DB::table('tags')->insert([
            'name' => '鳥',
            'group' => 'animal',
        ]);
        
    }
}
