<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('index') }}
        </h2>
    <!--navigation.blade.phpからナビゲーションバーの項目を追加できる-->
    </x-slot>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    </head>
    
    <body>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1>Home</h1>
                        <a href="/posts/create">新しい投稿を作成</a>
                        @foreach($posts as $post)
                            <div class="mt-6">
                                <a href="/posts/{{$post->id}}">
                                    <h2 class=title>{{$post->title}}</h2>
                                </a>
                                    <h3 class=body>{{$post->body}}</h3>
                                <a href="/categories/{{$post->category->id}}">
                                    <h4>{{$post->category->name}}</h4>
                                </a>
                                <div class="flex justify-end mt-4">
                                    <p class=user>投稿者：{{$post->user->name}}</p>
                                </div>
                                <a href="/posts/{{$post->id}}/edit">編集</a>
                                
                                <form id="{{$post->id}}" action="/posts/{{$post->id}}/delete" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="deletePost({{$post->id}})">削除</button>
                                    <!--deletePost({{$post->id}})で投稿のidを持った状態でjavascriptの関数が動く-->
                                </form>
                            </div>
                        @endforeach
                            
       
        
                    </div>
                </div>
            </div>
        </div>
         {{ $posts->links() }}
        <script>
            function deletePost($id){
                var del = window.confirm("本当に削除しますか。");
                if(del){
                    document.getElementById($id).submit();
                }
            }
        </script>
        <!--受けっとったidは$idで書くことで関数を動かす-->
    </body>
    </x-app-layout>
</html>
