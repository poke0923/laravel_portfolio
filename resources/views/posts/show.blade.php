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

    <!-- Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
    
</head>

<body class="antialiased">
    
    
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
                        
          <a href="/">back</a>
          
          <div id="map" style="height:500px; width:800px;"></div>
          
        </div>
      </div>
    </div>
  </div>

  
    <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})

        ({key: "APIKEY", v: "beta"});</script>

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