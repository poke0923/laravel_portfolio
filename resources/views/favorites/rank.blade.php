<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('投稿一覧') }}
        </h2>
    <!--navigation.blade.phpからナビゲーションバーの項目を追加できる-->
    </x-slot>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        
        
        <style>
            
            div.post{
                padding: 10px;
                margin: 10px;
                border: 1px solid gray;
                border-radius: 10px;
            }
            
        </style>

    </head>
    
    <body>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        
                        <!-- 検索機能ここから -->
                        <div>
                            <form acrion="{{ route('index') }}" method="GET">
                                @csrf
                                <input type="text" name="keyword">
                                <select name="category_id">
                                    <option value="0">すべて</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                                </select>
                                <input type="submit" value="検索">
                            </form>
                        </div>
                        <div>
                            <p>並び替え</p>
                            <a href = "/">投稿日時順</a>
                            <u><a href = "/favorites/rank">お気に入り数順</a></u>
                            <a href = "/posts/views/rank">閲覧数順</a>
                        </div>
                        <!-- 新規投稿機能ここから -->
                        <x-primary-button class="ml-3 mt-6">
                            <a href="{{ route('create') }}" class="newPost">新しい投稿を作成</a>
                        </x-primary-button>
                        
                        <!-- 投稿一覧表示ここから -->
                        @foreach($posts as $post)
                            <div class="post">
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
                                
                                <!-- お気に入り機能ここから -->
                                <!--https://biz.addisteria.com/laravel_nice_button/-->
                                <span>
                                    <!-- もし$favoriteがあれば＝ユーザーが「いいね」をしていたら -->
                                    @if( $post -> is_favorited($post) )
                                    
                                    <!-- 「いいね」取消用ボタンを表示 -->
                                    	<a href="{{ route('unfavorite', $post) }}" class="btn btn-success btn-sm">
                                    		いいね取り消し
                                    		<!-- 「いいね」の数を表示 -->
                                    		<span class="badge">
                                    			{{ $post->favorites->count() }}
                                    		</span>
                                    	</a>
                                    @else
                                    <!-- まだユーザーが「いいね」をしていなければ、「いいね」ボタンを表示 -->
                                    	<a href="{{ route('favorite', $post) }}" class="btn btn-secondary btn-sm">
                                    		いいね
                                    		<!-- 「いいね」の数を表示 -->
                                    		<span class="badge">
                                    			{{ $post->favorites->count() }}
                                    		</span>
                                    	</a>
                                    @endif
                                </span>
                                
                                </br>
                                <a href="/posts/{{$post->id}}/edit">編集</a>
                                
                                <form id="{{$post->id}}" action="/posts/{{$post->id}}/delete" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    
                                    <button type="button" onclick="deletePost({{$post->id}})" class="mt-4">削除</button>
                                    <!--deletePost({{$post->id}})で投稿のidを持った状態でjavascriptの関数が動く-->
                                    
                                </form>
                            </div>
                        @endforeach
                            
       
        
                    </div>
                </div>
            </div>
        </div>
         
         {{$posts->appends(request()->query())->links()}}
         <!--https://qiita.com/wbraver/items/b95814d6383172b07a58-->
         
         
         <!-- 削除機能のポップアップここから -->
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
