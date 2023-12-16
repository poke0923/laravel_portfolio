<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('投稿内容の編集') }}
        </h2>
    <!--navigation.blade.phpからナビゲーションバーの項目を追加できる-->
    </x-slot>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        
        <style>
            .error{
                color:red;
                font-weight:bold
            }
        </style>

        
    </head>
    
    <body onload="selected({{$post->category_id}})">
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form action="/posts/{{$post->id}}/edit" method="POST">
                        @csrf
                        @method('PUT')
                            <h2>投稿タイトル</h2>
                            <input type="text" name="post[title]" value="{{ old('post.title',$post->title) }}">
                            <p class="error">{{$errors->first('post.title')}}</p>
                            <!--
                            nameで指定した入れ子の構造（post[title]）は
                            それ以降は「.（ドット）」で繋いで取り出すことができる
                            -->
                            
                            <h2>写真説明</h2>
                            <textarea name="post[body]">{{ old('post.body',$post->body) }}</textarea>
                            <p class="error">{{$errors->first('post.body')}}</p>
                            
                            <h2>カテゴリー</h2>
                            <select id="category" name="post[category_id]">
                               
                                 @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                                
                                <!--
                                <option value=1>動物</option>
                                <option value=2>乗り物</option>
                                <option value=3>自然</option>
                                <option value="{{$post->category_id}}" selected>{{$post->category->name}}</option>
                                -->
                            </select>
                            </br>
                            <x-primary-button class="ml-3">
                                {{ __('保存') }}
                            </x-primary-button>
                            
                        </form>
                        
                        <a href="/">back</a>
                     </div>
                </div>
            </div>
        </div>
        <script>
            function selected(id){
                select = document.getElementById('category').options;
                
                for(let i = 0; i < select.length; i++){
                    if(select[i].value == id){
                        select[i].selected = true;
                        break;
                    }
                    //select[i].value == idのところは===にすると動かない
                    //厳密一致にするとダメな理由はわからない
                }
            }
            
           
        /*
             window.onload = function() {
                select = document.getElementById('category').options;
                for(let i = 0; i < select.length; i++ ){
                    if(select[i].value === '3'){
                        select[i].selected = true;
                        break;
                    }
                }
            }   
        
        */    
        </script>
    </body>
    
    </x-app-layout>
</html>
