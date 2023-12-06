<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    </head>
    
    <body>
        <h1>Blog Name</h1>
        <a href="/posts/create">create</a>
        @foreach($posts as $post)
        <a href="/posts/{{$post->id}}">
        <h2 class=title>{{$post->title}}</h2>
        </a>
        <h3 class=body>{{$post->body}}</h3>
        <a href="/posts/{{$post->id}}/edit">編集</a>
        @endforeach
        
        {{ $posts->links() }}
    </body>
</html>
