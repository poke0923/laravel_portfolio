<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        
    </head>
    
    <body>
        
        <h1>Blog Name</h1>
        
        <form action="/posts" method="POST">
        @csrf
            <h2>タイトル</h2>
            <input type="text" name="post[title]" value="{{ old('post.title') }}">
            <p>{{$errors->first('post.title')}}</p>
            <!--
            nameで指定した入れ子の構造（post[title]）は
            それ以降は「.（ドット）」で繋いで取り出すことができる
            -->
            
            <h2>本文</h2>
            <textarea name="post[body]">{{ old('post.body') }}</textarea>
            <p>{{$errors->first('post.body')}}</p>
            </br>
            <input type="submit" value="保存">
            
        </form>
        
        <a href="/">back</a>
        
    </body>
</html>
