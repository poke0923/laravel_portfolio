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
            'title'=>'test01',
            'body'=>'これはテストです',
            ]);
        
        DB::table('posts')->insert([
            'title'=>'test02',
            'body'=>'これはテストです',
            ]);
        DB::table('posts')->insert([
            'title'=>'test03',
            'body'=>'これはテストです',
            ]);
        DB::table('posts')->insert([
            'title'=>'test04',
            'body'=>'これはテストです',
            ]);
        DB::table('posts')->insert([
            'title'=>'test05',
            'body'=>'これはテストです',
            ]);
        
    }
}
