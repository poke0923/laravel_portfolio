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
        <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        @vite('resources/css/app.css')

        <title>Laravel</title>
        <style>
            .error{
                color:red;
                font-weight:bold
            }
        </style>

        
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
                        <form action="/posts" method="POST" enctype="multipart/form-data">
                        @csrf
                            <h2>投稿タイトル</h2>
                            <input type="text" name="post[title]" value="{{ old('post.title') }}">
                            <p class="error">{{$errors->first('post.title')}}</p>
                            
                            <!--
                            nameで指定した入れ子の構造（post[title]）は
                            それ以降は「.（ドット）」で繋いで取り出すことができる
                            -->
                            
                            <h2>写真説明</h2>
                            <textarea name="post[body]" class="whitespace-pre-wrap">{{ old('post.body') }}</textarea>
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
                            <div class="grid gap-1 grid-cols-3 p-3">
                                <div class="mb-4">
                                    <label class="block text-gray-700 dark:text-gray-400 text-md font-bold mb-2" for="pair">
                                        場所:
                                    </label>
                                    <select name="tag[]" class="js-example-basic-multiple", style="width: 100%" data-placeholder="Select a tag..." data-allow-clear="false" multiple="multiple" title="Select tag..." >
                                        @foreach($tags_spot as $tag)
                                            <option value="{{$tag->id}}">{{$tag->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 dark:text-gray-400 text-md font-bold mb-2" for="pair">
                                        自然:
                                    </label>
                                    <select name="tag[]" class="js-example-basic-multiple", style="width: 100%" data-placeholder="Select a tag..." data-allow-clear="false" multiple="multiple" title="Select tag..." >
                                        @foreach($tags_nature as $tag)
                                            <option value="{{$tag->id}}">{{$tag->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 dark:text-gray-400 text-md font-bold mb-2" for="pair">
                                        動物:
                                    </label>
                                    <select name="tag[]" class="js-example-basic-multiple", style="width: 100%" data-placeholder="Select a tag..." data-allow-clear="false" multiple="multiple" title="Select tag..." >
                                        @foreach($tags_animal as $tag)
                                            <option value="{{$tag->id}}">{{$tag->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
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
                            
                            <input type="file" name="image" onchange="previewImage(this);">
                            <p class="error">{{$errors->first('image')}}</p>
                            <p>
                            Preview:<br>
                            <img id="preview" src="" style="max-width:200px;">
                            </p>
                            </br>
                            </br>
                            </br>
                            <input type="submit" value="保存">
                            
                        </form>
                        
                        <a href="/">back</a>
                     </div>
                </div>
            </div>
        </div>

        <script src="https://maps.googleapis.com/maps/api/js?key={{config('services.googleMap.apikey')}}&callback=initAutocomplete&libraries=places&v=weekly"defer></script>

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
          
                const mapicon = google.maps.importLibrary("marker");
          
                // Create a marker for each place.
                markers.push(
                  new google.maps.Marker({
                    map,
                    icon:mapicon,
                    title: place.name,
                    position: place.geometry.location,
                  }),
                );
                
                if (place.geometry.viewport) {
                  
                  // Only geocodes have viewport.
                  bounds.union(place.geometry.viewport);
                } else {
                  bounds.extend(place.geometry.location);
                }
                
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
