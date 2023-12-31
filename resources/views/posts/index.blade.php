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
        <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        @vite('resources/css/app.css')
       

        <title>Laravel</title>


    </head>
    
    <body>
        
        <script type="text/javascript">
            
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });
        </script>
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- 検索機能ここから -->
                        <div>
                            <form acrion="{{ route('index') }}" method="GET" class="bg-white border rounded px-8 pt-6 pb-8 mb-4">
                                @csrf
                                <input type="text" name="keyword">
                                <select name="category_id">
                                    <option value="0">すべて</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                                </select>
                                </br>
                                <select name="tag[]" class="js-example-basic-multiple", style="width: 100%" data-placeholder="Select a tag..." data-allow-clear="false" multiple="multiple" title="Select tag..." >
                                    </br>
                                    @foreach($tags as $tag)
                                    
                                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                                    
                                    @endforeach
                                </select>
                        </div>
                        

                                <input type="submit" value="検索">
                            </form>
                        </div>
                        <!--並び替え機能ここから
                        <div>
                            <p>並び替え</p>
                            <a href = "/">投稿日時順</a>
                            <a href = "/favorite/posts/rank">お気に入り数順</a>
                        
                        </div>
                        -->
                        
                        
                        <!-- 新規投稿機能ここから -->
                        <x-primary-button class="ml-3 mt-6">
                            <a href="{{ route('create') }}" class="newPost">新しい投稿を作成</a>
                        </x-primary-button>
                        
                        <!-- 投稿一覧表示ここから -->
                        <div class="grid gap-4 grid-cols-3 grid-rows-3 p-5">
                        @foreach($posts as $post)
                            <div class="p-5 border border-gray-400 border-solid">
                                <!-- 投稿タイトル -->
                                <a href="/posts/{{$post->id}}">
                                    <h2 class=title>{{$post->title}}</h2>
                                </a>
                                
                                <!-- カテゴリー -->
                                <a href="/categories/{{$post->category->id}}">
                                    <h4>{{$post->category->name}}</h4>
                                </a>
                                
                                <div class="flex gap-1">
                                    <!-- 投稿に紐づくタグ -->
                                    @foreach($post->post_tags($post) as $tag)
                                        <a href="/tags/{{$tag->id}}" class="text-center text-xs bg-gray-700 hover:bg-gray-600 text-white rounded px-2 py-1 my-1">
                                            <p>{{$tag->name}}</p>
                                        </a>
                                    @endforeach
                                </div>
                                
                                <!-- 写真 -->
                                <img src="{{ $post->image_path }}" style="w-20">
                                
                                <!-- 投稿者 -->
                                <div class="flex my-2 gap-1">
                                    <a href={{ route('profile',$post->user_id) }}><p class=user>投稿者：{{$post->user->name}}</p></a>
                                    
                                    <!-- フォロー機能ここから -->
                                    <div>
                                        @if($post->user_id !== Auth::user()->id )
                                            @if( $post->is_followed($post) )
                                            	<a href = "{{ route('unfollow', $post->user_id) }}" class="bg-gray-500 hover:bg-gray-400 text-white text-xs rounded px-4 py-2">
                                            		フォロー解除
                                            	</a>
                                            @else
                                            	<a href = "{{ route('follow', $post->user_id) }}" class="bg-blue-700 hover:bg-blue-600 text-white text-xs rounded px-4 py-2">
                                            		フォロー
                                            	</a>
                                            @endif
                                        @endif
                                    </div>
                                    
                                </div>
                                <p>投稿日：{{ $post->created_at->toDateString() }}</p>
                                
                                <!-- お気に入り機能ここから -->
                                <!--https://biz.addisteria.com/laravel_nice_button/-->
                                <span>
                                    <!-- もし$favoriteがあれば＝ユーザーが「いいね」をしていたら -->
                                    @if( $post -> is_favorited($post) )
                                    
                                    <!-- 「いいね」取消用ボタンを表示 -->
                                    	<a href="{{ route('unfavorite', $post) }}" class="text-xs text-center bg-red-700 hover:bg-red-600 text-white rounded px-4 py-2">
                                    		♥
                                    		<!-- 「いいね」の数を表示 -->
                                    		<span class="badge">
                                    			{{ $post->favorites->count() }}
                                    		</span>
                                    	</a>
                                    @else
                                    <!-- まだユーザーが「いいね」をしていなければ、「いいね」ボタンを表示 -->
                                    	<a href="{{ route('favorite', $post) }}" class="bg-gray-500 hover:bg-gray-400 text-white text-xs rounded px-4 py-2">
                                    		♡
                                    		<!-- 「いいね」の数を表示 -->
                                    		<span class="badge">
                                    			{{ $post->favorites->count() }}
                                    		</span>
                                    	</a>
                                    @endif
                                </span>
                                
                                </br>
                                @if($post->user_id == Auth::user()->id)
                                <a href="/posts/{{$post->id}}/edit">編集</a>
                                
                                
                                <form id="{{$post->id}}" action="/posts/{{$post->id}}/delete" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    
                                    <button type="button" onclick="deletePost({{$post->id}})" class="mt-4">削除</button>
                                    <!--deletePost({{$post->id}})で投稿のidを持った状態でjavascriptの関数が動く-->
                                    
                                </form>
                                @endif
                            </div>
                        @endforeach
                        </div>
                            
       
        
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
