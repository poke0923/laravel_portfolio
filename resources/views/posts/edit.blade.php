<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('投稿内容の編集') }}
        </h2>
    <!--navigation.blade.phpからナビゲーションバーの項目を追加できる-->
    </x-slot>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        
        <style>
            .error{
                color:red;
                font-weight:bold
            }
        </style>

        
    </head>
    
    <body>
    <!--
    このonloadでカテゴリーの初期値をもともと選択していたカテゴリーにする。
    下のほうにjavascriptが書いてある。
    selected({{$post->category_id}})で関数に投稿のcategory_idを受け渡ししている。
    -->
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form action="/posts/{{$post->id}}/edit" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                            <h2>投稿タイトル</h2>
                            <input type="text" name="post[title]" value="{{ old('post.title',$post->title) }}">
                            <p class="error">{{$errors->first('post.title')}}</p>
                            <!--
                            nameで指定した入れ子の構造（post[title]）は
                            それ以降は「.（ドット）」で繋いで取り出すことができる
                            -->
                            <h2>写真</h2>
                            <p>現在の画像</p>
                            <img src="{{ $post->image_path }}" style="max-width:200px;">
                            <p>⇒</p>
                            <h2>変更後の画像</h2>
                            <input type="file" name="image" onchange="previewImage(this);">
                            <p>
                            Preview:<br>
                            <img id="preview" src="" style="max-width:200px;">
                            </p>
                            
                            <h2>写真説明</h2>
                            <textarea name="post[body]">{{ old('post.body',$post->body) }}</textarea>
                            <p class="error">{{$errors->first('post.body')}}</p>
                            
                            <h2>カテゴリー</h2>
                            <select id="category" name="post[category_id]">
                               
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}"{{ $category->id === $post->category_id ? "selected":"" }}>{{$category->name}}</option>
                                @endforeach
                                
                            </select>
                            
                            <h2>tag</h2>
                            @foreach($tags as $tag)
                                <input type="checkbox" name="tag[]" value="{{$tag->id}}" {{ in_array($tag->id, $post->tags->pluck('id')->toArray()) ? 'checked' : '' }}><label>{{$tag->name}}</label>
                                <!--
                                in_array()?'checked':''これの?以降で場合分け。trueならchecked、falseなら''を返す
                                in_array(探したい値, 配列)で配列の中に探したい値があればtrue、なければfalseを返す
                                やりたいことは「このタグのidってこのポストが持つタグのidと一致してますか？」ということなので
                                1.探したい値にこのタグのid、配列にこの投稿の持つタグのidを持ってくる
                                2.この投稿の持つタグのidは$postでこの投稿を取得
                                3.tagsでこの投稿が持つタグにアクセス、
                                4.pluck('id')でアクセスした先のデータからidだけ取得 https://qiita.com/jacksuzuki/items/eae943735bda747be09c
                                5.toArrayで配列に変換している。
                                -->
                            @endforeach
                            
                            <h2>撮影場所</h2>
                            <input
                                id="pac-input"
                                class="controls"
                                type="text"
                                placeholder="Search Box"
                              />
                            <div id="map" style="height:500px; width:800px;"></div>
                            <div>lat: <input id="lat" name="post[latitude]" type="text" value="{{$post->latitude}}"/></div>
                            <div>lng: <input id="lng" name="post[longitude]" type="text" value="{{$post->longitude}}"/></div>
                            </br>
                            <x-primary-button class="mt-3">
                                {{ __('保存') }}
                            </x-primary-button>
                            
                        </form>
                        
                        <a href="/">back</a>
                     </div>
                </div>
            </div>
        </div>
        <script src="https://maps.googleapis.com/maps/api/js?key={{config('services.googleMap.apikey')}}&callback=initAutocomplete&libraries=places&v=weekly"defer></script>

        <script>
          function initAutocomplete($post) {
            const map = new google.maps.Map(document.getElementById("map"), {
              center: { lat: {{$post->latitude}}, lng: {{$post->longitude}} },
              zoom: 13,
              mapTypeId: "roadmap",
            });
            
            new google.maps.Marker({
                position:  { lat: {{$post->latitude}}, lng: {{$post->longitude}} },
                map,
                title: "location",
              }); 
            
            
            // Create the search box and link it to the UI element.
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);
            
          
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            // Bias the SearchBox results towards current map's viewport.
            map.addListener("bounds_changed", () => {
              searchBox.setBounds(map.getBounds());
            });
          
            let markers = [];
          
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener("places_changed", () => {
              const places = searchBox.getPlaces();
          
              if (places.length == 0) {
                return;
              }
          
              // Clear out the old markers.
              markers.forEach((marker) => {
                marker.setMap(null);
              });
              markers = [];
          
              // For each place, get the icon, name and location.
              const bounds = new google.maps.LatLngBounds();
          
              places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                  console.log("Returned place contains no geometry");
                  return;
                }
          
                const icon = {
                  url: place.icon,
                  size: new google.maps.Size(71, 71),
                  origin: new google.maps.Point(0, 0),
                  anchor: new google.maps.Point(17, 34),
                  scaledSize: new google.maps.Size(25, 25),
                };
          
                // Create a marker for each place.
                markers.push(
                  new google.maps.Marker({
                    map,
                    icon,
                    title: place.name,
                    position: place.geometry.location,
                  }),
                );
                
                if (place.geometry.viewport) {
                  
                  // Only geocodes have viewport.
                  bounds.union(place.geometry.viewport);
                } else {
                  console.log(place.geometry.location);
                  bounds.extend(place.geometry.location);
                }
                console.log(place.geometry.location);
                document.getElementById("lat").value = place.geometry.location.lat();
                document.getElementById("lng").value = place.geometry.location.lng();
                
              });
              
              map.fitBounds(bounds);
            });
          }
          
          window.initAutocomplete = initAutocomplete;
        </script>
        <script>
          function previewImage(obj)
          {
          	var fileReader = new FileReader();
          	fileReader.onload = (function() {
          		document.getElementById('preview').src = fileReader.result;
          	});
          	fileReader.readAsDataURL(obj.files[0]);
          }
        </script>
        
    </body>
    
    </x-app-layout>
</html>