<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('投稿内容の詳細') }}
        </h2>
    <!--navigation.blade.phpからナビゲーションバーの項目を追加できる-->
    </x-slot>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        
    </head>
    
    <body>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class=title>{{$post->title}}</h2>
                        
                        <h3 class=body>{{$post->body}}</h3>
                        
                        <h3 class=category>{{$post->category->name}}</h3>
                        <div class="flex justify-end mt-4">
                            <p class=user>投稿者：{{$post->user->name}}</p>
                        </div>
                        
                        <span>
                                    <img src="{{asset('img/nicebutton.png')}}" width="30px">
                                     
                                    <!-- もし$favoriteがあれば＝ユーザーが「いいね」をしていたら -->
                                    @if($favorite)
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
                        
                        <a href="/">back</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </x-app-layout>
</html>
