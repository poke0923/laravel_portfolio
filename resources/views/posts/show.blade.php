<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        
    </head>
    
    <body>
        <h1>Blog Name</h1>
        
        <h2 class=title>{{$post->title}}</h2>
        
        <h3 class=body>{{$post->body}}</h3>
        
        <a href="/">back</a>
        
    </body>
</html>
