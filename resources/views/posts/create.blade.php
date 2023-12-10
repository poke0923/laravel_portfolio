<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        
        <h1>Blog Name</h1>
        
        <form action="/posts" method="POST">
        @csrf
            <h2>タイトル</h2>
            <input type="text" name="post[title]" value="{{ old('post.title') }}">
            <p class="error">{{$errors->first('post.title')}}</p>
            <!--
            nameで指定した入れ子の構造（post[title]）は
            それ以降は「.（ドット）」で繋いで取り出すことができる
            -->
            
            <h2>本文</h2>
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
            </br>
            </br>
            </br>
            <input type="submit" value="保存">
            
        </form>
        
        <a href="/">back</a>
        
    </body>
</html>
