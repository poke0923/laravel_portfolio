<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        @vite('resources/css/app.css')
       

        <title>PhotoPlace</title>


    </head>
    
    <body>
        
        <script type="text/javascript">
            
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });
        </script>
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="p-6 text-gray-900">
                        @if($header!==null)
                        <div class="relative">
                            <div class="absolute px-6 py-24 h-full items-center justify-center bg-white bg-opacity-50">
                                <div class="shrink-0 flex items-center">
                                    <div class="inline-flex items-end tracking-widest">
                                        <p class="title-font font-medium  text-gray-900 text-6xl">P</p>
                                        <p class=" text-gray-500 text-2xl">hoto</p>
                                        <p class="title-font font-medium  text-gray-900 text-6xl">P</p>
                                        <p class=" text-gray-500 text-2xl">lace</p>
                                    </div>
                                </div>
                            </div> 
                            <img src="{{ $header->image_path }}" class="h-64 sm:h-80 w-full overflow-hidden object-cover ">
                        </div>
                        @endif
                        
                        <!-- 検索機能ここから -->
                        <h1 class="mt-6 mb-3 underline underline-offset-4 decoration-orange-700 text-2xl">投稿検索</h1>
                        <div>
                            <form action="{{ route('index') }}" method="GET" class="text-sm bg-gray-100 border border-gray-200 rounded px-8 pt-6 pb-8 m-4">
                            @csrf
                                <input type="text" name="keyword" value="{{ session('serch_keyword')}}">
                                <select name="category_id">
                                    <option value="0" >すべて</option>
                                    
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{ $category->id == session('serch_categoryId') ? "selected":"" }} >{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                </br>
                                <div class="grid gap-1 grid-cols-3 p-3">
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-400 text-md font-bold mb-2 " for="pair">
                                            場所:
                                        </label>
                                        <select name="tag[]" class="js-example-basic-multiple", style="width: 100%" data-placeholder="Select a tag..." data-allow-clear="false" multiple="multiple" title="Select tag..." >
                                            @foreach($tags_spot as $tag)
                                                <option value="{{$tag->id}}" {{ in_array($tag->id, session('serch_tagsId')) ? "selected":"" }}>{{$tag->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-400 text-md font-bold mb-2" for="pair">
                                            自然:
                                        </label>
                                        <select name="tag[]" class="js-example-basic-multiple", style="width: 100%" data-placeholder="Select a tag..." data-allow-clear="false" multiple="multiple" title="Select tag..." >
                                            @foreach($tags_nature as $tag)
                                                <option value="{{$tag->id}}" {{ in_array($tag->id, session('serch_tagsId')) ? "selected":"" }}>{{$tag->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-400 text-md font-bold mb-2" for="pair">
                                            動物:
                                        </label>
                                        <select name="tag[]" class="js-example-basic-multiple", style="width: 100%" data-placeholder="Select a tag..." data-allow-clear="false" multiple="multiple" title="Select tag..." >
                                            @foreach($tags_animal as $tag)
                                                <option value="{{$tag->id}}" {{ in_array($tag->id, session('serch_tagsId')) ? "selected":"" }}>{{$tag->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                <input type="submit" class=" bg-gray-900 hover:bg-gray-800 text-white rounded px-4 py-2" value="検索">
                                </div>
                            </form>
                        </div>
                        
                        <!-- 投稿一覧表示ここから -->
                        <h1 class="mt-12 underline underline-offset-4 decoration-orange-700 text-2xl">投稿一覧</h1>
                        <section class="text-gray-600 body-font">
                            <div class="container px-2 py-12 mx-auto">
                                @if( $posts->isEmpty())
                                <div>条件に当てはまる投稿がありません</div>
                                @else
                                <div class="flex flex-wrap -m-4">
                                    @foreach($posts as $post)
                                        <div class="p-1 w-1/3">
                                            <div class="bg-white h-full sm:border-1 sm:border-gray-200 sm:border-opacity-60 sm:rounded-lg overflow-hidden">
                                                <!-- 写真 -->
                                                <a href="/posts/{{$post->id}}">
                                                    <img src="{{ $post->image_path }}" class="rounded-lg lg:h-48 md:h-36 h-24 w-full object-cover object-center hover:scale-110 duration-700">
                                                </a>
                                                
                                                <div class="hidden md:inline-block md:w-full md:px-6 md:py-3">
                                                    <div class="flex items-center flex-wrap ">
                                                        <!-- カテゴリー -->
                                                        <a href="/categories/{{$post->category->id}}" class="hover:underline inline-flex items-center tracking-widest text-sm title-font font-medium text-gray-400 mb-1">
                                                            {{ $post->category->id == 1 ? "": $post->category->name }}
                                                        </a>
                                                        <!-- 投稿者 -->
                                                        <div class="flex ml-auto">
                                                            <a href={{ route('profile',$post->user_id) }} class="ml-auto leading-none title-font font-medium text-sm rounded mb-2">
                                                                投稿者：{{$post->user->name}}
                                                            </a>
                                                            @if($post->user_id == Auth::user()->id)
                                                                <div class="relative group ">
                                                                    <div>
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" h-4 ">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                                                        </svg>
                                                                    </div>
                                                                    <div class="absolute invisible group-hover:visible bg-white rounded-lg text-right text-xs right-2 p-3">
                                                                        <a href="/posts/{{$post->id}}/edit" class="hover:bg-gray-200 hover:rounded-sm">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hover:bg-gray-300 w-3 h-3 mb-1">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                                            </svg>
                                                                        </a>
                                                                        <form id="{{$post->id}}" action="/posts/{{$post->id}}/delete" method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            
                                                                            <button type="button" onclick="deletePost({{$post->id}})" class="">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="red" class="hover:bg-gray-300 w-3 h-3">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                                </svg>
                                                                            </button>
                                                                            <!--deletePost({{$post->id}})で投稿のidを持った状態でjavascriptの関数が動く-->
                                                                            
                                                                        </form>
                                                                        
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <!-- 投稿タイトル -->
                                                    <a href="/posts/{{$post->id}}">
                                                        <h1 class="title-font text-md font-medium text-gray-900 mb-3">{{$post->title}}</h1>
                                                    </a>
                                                    <div class="flex items-center flex-wrap">
                                                        <!-- 投稿に紐づくタグ -->
                                                        @foreach($post->post_tags($post) as $tag)
                                                            <a href="/tags/{{$tag->id}}" class="text-gray-500 text-xs hover:underline inline-flex items-center mr-2">
                                                                {{$tag->name}}
                                                            </a>
                                                        @endforeach
                                                        <!-- お気に入り機能ここから -->
                                                        <!--https://biz.addisteria.com/laravel_nice_button/-->
                                                        
                                                        <!-- もしユーザーが「いいね」をしていたら -->
                                                        @if( $post -> is_favorited($post) )
                                                        <!-- 「いいね」取消用ボタンを表示 -->
                                                        	<a href="{{ route('unfavorite', $post) }}" class="ml-auto leading-none bg-red-500 hover:bg-red-400 text-white text-xs rounded px-3 py-2">
                                                        		♥ {{ $post->favorites->count() }}
                                                        	</a>
                                                        @else
                                                        <!-- まだユーザーが「いいね」をしていなければ、「いいね」ボタンを表示 -->
                                                        	<a href="{{ route('favorite', $post) }}" class="ml-auto leading-none bg-gray-500 hover:bg-gray-400 text-white text-xs rounded px-3 py-2">
                                                        		♡ {{ $post->favorites->count() }}
                                                        		
                                                        	</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </section>
  
                           {{$posts->appends(request()->query())->links('vendor.pagination.tailwind')}}
                             <!--https://qiita.com/wbraver/items/b95814d6383172b07a58-->
                        </div>
                    </div>
            </div>
        </div>
         
         
         
         
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
