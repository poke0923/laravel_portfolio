<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('新規投稿作成') }}
        </h2>
    <!--navigation.blade.phpからナビゲーションバーの項目を追加できる-->
    </x-slot>
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <style>
            .error{
                color:red;
                font-weight:bold
            }
        </style>

        
    </head>
    
    <body>
       <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form action="/posts" method="POST">
                        @csrf
                            <h2>投稿タイトル</h2>
                            <input type="text" name="post[title]" value="{{ old('post.title') }}">
                            <p class="error">{{$errors->first('post.title')}}</p>
                            
                            <!--
                            nameで指定した入れ子の構造（post[title]）は
                            それ以降は「.（ドット）」で繋いで取り出すことができる
                            -->
                            
                            <h2>写真説明</h2>
                            <textarea name="post[body]">{{ old('post.body') }}</textarea>
                            <p class="error">{{$errors->first('post.body')}}</p>
                            <!--
                            バリデーションのエラーメッセージのattributeはリクエストクラス（PostRequest）で指定できる
                            -->
                            <h2>カテゴリー</h2>
                            <select name="post[category_id]">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            
                            <h2>タグ</h2>
                            @foreach($tags as $tag)
                                <input type="checkbox" name="tag[]" value="{{$tag->id}}"><label>{{$tag->name}}</label>
                            @endforeach
                            
                            <h2>撮影場所</h2>
                            <input
                                id="pac-input"
                                class="controls"
                                type="text"
                                placeholder="Search Box"
                              />
                            <div id="map" style="height:500px; width:800px;"></div>
                            <div>lat: <input id="lat" name="post[latitude]" type="text"/></div>
                            <div>lng: <input id="lng" name="post[longitude]" type="text"/></div>
                            
                            </br>
                            </br>
                            </br>
                            <x-primary-button class="ml-3">
                                {{ __('保存') }}
                            </x-primary-button>
                            
                        </form>
                        
                        <a href="/">back</a>
                     </div>
                </div>
            </div>
        </div>

        <script src="https://maps.googleapis.com/maps/api/js?key=APIKEY&callback=initAutocomplete&libraries=places&v=weekly"defer></script>

        <script>
          function initAutocomplete() {
            const map = new google.maps.Map(document.getElementById("map"), {
              center: { lat: 35.6812362, lng: 139.7671248 },
              zoom: 13,
              mapTypeId: "roadmap",
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
        
    </body>
    </x-app-layout>
</html>
