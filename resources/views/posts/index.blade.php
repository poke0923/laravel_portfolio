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
        <h4>{{$post->category->name}}</h4>
        
        <a href="/posts/{{$post->id}}/edit">編集</a>
        
        <form id="{{$post->id}}" action="/posts/{{$post->id}}/delete" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" onclick="deletePost({{$post->id}})">削除</button>
            <!--deletePost({{$post->id}})で投稿のidを持った状態でjavascriptの関数が動く-->
        </form>
        @endforeach
        
        {{ $posts->links() }}
        
        <script>
            function deletePost($id){
                var del = window.confirm("削除すると復元できません。本当に削除しますか。");
                if(del){
                    document.getElementById($id).submit();
                }
            }
        </script>
        <!--受けっとったidは$idで書くことで関数を動かす-->
    </body>
</html>
