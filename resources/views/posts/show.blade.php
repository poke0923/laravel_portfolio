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
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

</head>

<body>
  <section class="text-gray-600 body-font">
        <div class="container px-12 mx-auto flex flex-col">
          
            <div class="flex justify-center">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">{{$post->title}}</h1>
            </div>
            <div class="flex flex-col sm:flex-row sm:space-x-4 justify-center pb-2">
              <div class="inline-flex items-center justify-center">投稿日：{{ $post->created_at->toDateString() }}</div>
              <div class="flex items-center justify-center">
                <a href={{ route('profile',$post->user_id) }}>投稿者：{{$post->user->name}}</a>
                <div class="inline-flex items-center ml-2">
                  @if($post->user_id !== Auth::user()->id )
                      @if( $post->is_followed($post) )
                      	<a href = "{{ route('unfollow', $post->user_id) }}" class="bg-gray-600 hover:bg-gray-500 text-white text-xs rounded px-2 py-1">
                      		フォロー解除{{$post->follow_count($post)}}
                      	</a>
                      @else
                      	<a href = "{{ route('follow', $post->user_id) }}" class="bg-blue-600 hover:bg-blue-500 text-white text-xs rounded px-2 py-1">
                      		フォロー{{$post->follow_count($post)}}
                      	</a>
                      @endif
                  @endif
                </div>
                <div class="inline-flex items-center ml-2">
                  <!-- お気に入り機能ここから -->
                  <!--https://biz.addisteria.com/laravel_nice_button/-->
                  
                  <!-- もしユーザーが「いいね」をしていたら -->
                  @if( $post -> is_favorited($post) )
                  <!-- 「いいね」取消用ボタンを表示 -->
                  	<a href="{{ route('unfavorite', $post) }}" class="bg-red-500 hover:bg-red-400 text-white text-xs rounded px-2 py-1">
                  		♥ {{ $post->favorites->count() }}
                  	</a>
                  @else
                  <!-- まだユーザーが「いいね」をしていなければ、「いいね」ボタンを表示 -->
                  	<a href="{{ route('favorite', $post) }}" class="bg-gray-500 hover:bg-gray-400 text-white text-xs rounded px-2 py-1">
                  		♡ {{ $post->favorites->count() }}
                  		
                  	</a>
                  @endif
                </div>
                
                @if($post->user_id == Auth::user()->id)
                    <div class="inline-flex items-center ml-4">
                      <a href="/posts/{{$post->id}}/edit" class="hover:bg-gray-200 hover:rounded-sm">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hover:bg-gray-300 w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                          </svg>
                      </a>
                    </div>
                    
                      <form id="{{$post->id}}" action="/posts/{{$post->id}}/delete" method="POST" class="inline-flex items-center">
                          @csrf
                          @method('DELETE')
                          
                          <button type="button" onclick="deletePost({{$post->id}})" class="ml-2 ">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="red" class="hover:bg-gray-300 w-6 h-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                              </svg>
                          </button>
                          <!--deletePost({{$post->id}})で投稿のidを持った状態でjavascriptの関数が動く-->
                          
                      </form>
                    
                            
                   
                @endif
                
              </div>
            </div>
        </div>
        
              <div class="px-12 md:px-48 flex justify-center h-96">
                <img src="{{ $post->image_path }}" class="rounded-lg object-center object-cover" >
              </div>
              
              <div class="mt-2 pt-4 text-center">
                <p class="leading-relaxed text-md mb-4 whitespace-pre-wrap">{{$post->body}}</p>
              </div>
              
              <div class="flex flex-col sm:flex-row mt-5 px-12 md:px-48">
                <div class="sm:flex sm:flex-col inline-flex justify-center sm:w-1/3 text-center sm:pr-8 sm:py-8 space-x-8 sm:space-x-0">
                  <div class="flex flex-col items-center text-center justify-center">
                    <h2 class="font-medium title-font text-gray-900 text-lg">Category</h2>
                    <div class="w-12 h-1 bg-indigo-500 rounded mt-2 mb-4"></div>
                    <p class="text-base hover:underline">{{$post->category->name}}</p>
                  </div>
                  <div class="flex flex-col sm:mt-4 items-center text-center justify-center">
                    <h2 class="font-medium title-font text-gray-900 text-lg">Tag</h2>
                    <div class="w-12 h-1 bg-indigo-500 rounded mt-2 mb-4"></div>
                    <div class="flex flex-wrap text-base">
                      @foreach($post->post_tags($post) as $tag)
                        <a href="/tags/{{$tag->id}}" class="ml-1 hover:underline">
                            <p>{{$tag->name}}</p>
                        </a>
                      @endforeach
                    </div>
                  </div>
                </div>
                
                <div class="sm:w-2/3 px-8 sm:py-8 sm:border-l border-gray-200 sm:border-t-0 border-t mt-4 pt-4 sm:mt-0 text-center sm:text-left">
                    <div class="rounded-lg h-64 overflow-hidden">
                      <div id="map" class="object-cover object-center pr-12 h-full w-full"></div>
                    </div>
                </div>
                
              </div>
              <div class="flex justify-center space-x-8">
                <a href="{{url()->previous()}}" class="text-indigo-500 inline-flex items-center">前のページに戻る</a>
                <a href="/" class="text-indigo-500 inline-flex items-center">投稿一覧に戻る</a>
              </div>
            </div>
          </div>
        </section>
    <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})

        ({key: "{{config('services.googleMap.apikey')}}", v: "beta"});</script>

    <script>
            // Initialize and add the map
      let map;
      
      async function initMap($post) {
        
        const position = { lat: {{$post->latitude}}, lng: {{$post->longitude}} };
        // Request needed libraries.
        //@ts-ignore
        const { Map } = await google.maps.importLibrary("maps");
        const { AdvancedMarkerView } = await google.maps.importLibrary("marker");
      
        // The map
        map = new Map(document.getElementById("map"), {
          zoom: 13,
          center: position,
          mapId: "MAP_ID",
        });
      
        // The marker
        const marker = new AdvancedMarkerView({
          map: map,
          position: position,
          title: "location",
        });
      }
      
      initMap();
    </script>
    
    
    
</body>

</x-app-layout>
</html>