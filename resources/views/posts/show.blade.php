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
        <div class="container px-5 py-24 mx-auto flex flex-col">
          <div class="">
    <div class="flex justify-center">
        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">{{$post->title}}</h1>
    </div>
        <div class="flex space-x-4 justify-center pb-2">
            <div class="">投稿日：{{ $post->created_at->toDateString() }}</div>
            <div class="flex items-center">
              <a href={{ route('profile',$post->user_id) }}>投稿者：{{$post->user->name}}</a>
              <div class="inline-flex items-center ml-2">
                @if($post->user_id !== Auth::user()->id )
                    @if( $post->is_followed($post) )
                    	<a href = "{{ route('unfollow', $post->user_id) }}" class="bg-gray-600 hover:bg-gray-500 text-white text-xs rounded px-2 py-1">
                    		フォロー{{$post->follow_count($post)}}
                    	</a>
                    @else
                    	<a href = "{{ route('follow', $post->user_id) }}" class="bg-blue-600 hover:bg-blue-500 text-white text-xs rounded px-2 py-1">
                    		フォロー{{$post->follow_count($post)}}
                    	</a>
                    @endif
                @endif
              </div>
            </div>
            
            
        </div>
        
              <div class="rounded-lg ">
                <img src="{{ $post->image_path }}" class="object-cover object-center h-full w-full" >
              </div>
              <div class="mt-2 pt-4 text-center">
                <p class="leading-relaxed text-lg mb-4 whitespace-pre-wrap">{{$post->body}}</p>
              </div>
              <div class="flex flex-col sm:flex-row mt-5">
                <div class="sm:flex sm:flex-col inline-flex justify-center sm:w-1/3 text-center sm:pr-8 sm:py-8">
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
                <div class="sm:w-2/3 sm:pl-8 sm:py-8 sm:border-l border-gray-200 sm:border-t-0 border-t mt-4 pt-4 sm:mt-0 text-center sm:text-left">
                    <div class="rounded-lg h-64 overflow-hidden">
                      <div id="map" class="object-cover object-center h-full w-full"></div>
                    </div>
                </div>
              </div>
              <a href="{{url()->previous()}}" class="text-indigo-500 inline-flex items-center">back</a>
            </div>
          </div>
        </section>
        
  <div class="font-medium">
          
          <span>  
            <!-- もし$favoriteがあれば＝ユーザーが「いいね」をしていたら -->
            @if($post->is_favorited($post))
            <!-- 「いいね」取消用ボタンを表示 -->
              <a href="{{ route('unfavorite', $post) }}" class="btn btn-success btn-sm">
                いいね取り消し
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
         
          
  </div>
          
      

  
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