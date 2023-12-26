<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('新規投稿作成') }}
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
    
    <body>
       <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form action="/posts" method="POST">
                        @csrf
                            <h2>投稿タイトル</h2>
                            <input type="text" name="post[title]" value="{{ old('post.title') }}">
                            <p class="error">{{$errors->first('post.title')}}</p>
                            
                            <!--
                            nameで指定した入れ子の構造（post[title]）は
                            それ以降は「.（ドット）」で繋いで取り出すことができる
                            -->
                            
                            <h2>写真説明</h2>
                            <textarea name="post[body]">{{ old('post.body') }}</textarea>
                            <p class="error">{{$errors->first('post.body')}}</p>
                            <!--
                            バリデーションのエラーメッセージのattributeはリクエストクラス（PostRequest）で指定できる
                            -->
                            <h2>カテゴリー</h2>
                            <select name="post[category_id]">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            
                            <h2>タグ</h2>
                            @foreach($tags as $tag)
                                <input type="checkbox" name="tag[]" value="{{$tag->id}}"><label>{{$tag->name}}</label>
                            @endforeach
                            
                            </br>
                            </br>
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
        
    </body>
    </x-app-layout>
</html>
