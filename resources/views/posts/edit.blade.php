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
        <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        @vite('resources/css/app.css')

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
      <script type="text/javascript">
      
      $(document).ready(function() {
          $('.js-example-basic-multiple').select2();
      });
      
      </script>
        <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-600 font-medium">
                <p class="text-xl mb-4">投稿を編集</p>
                <form action="/posts/{{$post->id}}/edit" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="flex flex-col lg:flex lg:flex-row">
                    <section class="w-full lg:w-1/3">
                      <h2 class="underline underline-offset-4 decoration-orange-700 mb-2">投稿タイトル</h2>
                      <input type="text" name="post[title]" value="{{ old('post.title',$post->title) }}" class="w-full lg:w-5/6 mr-2 rounded-lg bg-gray-200 border-0">
                      <p class="error">{{$errors->first('post.title')}}</p>
                        <!--
                        nameで指定した入れ子の構造（post[title]）は
                        それ以降は「.（ドット）」で繋いで取り出すことができる
                        -->
                      <h2 class="underline underline-offset-4 decoration-orange-700 mb-2 mt-4">写真説明</h2>
                      <textarea name="post[body]" class="h-36 w-full lg:w-5/6 mr-2 whitespace-pre-wrap rounded-lg bg-gray-200 border-0">{{ old('post.body',$post->body) }}</textarea>
                      <p class="error">{{$errors->first('post.body')}}</p>
                      
                      <h2 class="underline underline-offset-4 decoration-orange-700 mb-2 mt-4">カテゴリー</h2>
                      <select id="category" name="post[category_id]" class="rounded-lg border-0">
                          @foreach($categories as $category)
                              <option value="{{$category->id}}" {{ $category->id === $post->category_id ? "selected":"" }}>{{$category->name}}</option>
                          @endforeach
                      </select>
                    </section>
                    
                    <section class="w-full mt-4 lg:mt-0 lg:w-2/3 flex flex-col items-center justify-center">
                      <h2 class="lg:hidden underline underline-offset-4 decoration-orange-700 mb-2 mt-4">写真選択</h2>
                      <h2 class="invisible lg:visible underline underline-offset-4 decoration-orange-700 mb-8 ">画像変更</h2>
                      <div class="flex flex-col lg:flex lg:flex-row items-center justify-center space-x-8">
                        <div>
                          
                          <img src="{{ session()->has('preImage') ? session()->get('preImage') :$post->image_path }}" class="max-w-48 max-h-48 sm:max-w-72 sm:max-h-72 mb-2">
                        </div>
                        
                          <div class="invisible lg:visible ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                          </div>
                          <div class="lg:hidden mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                            </svg>
                          </div>
                        <div class="flex flex-col justify-center items-center ">
                          <img id="preview" src="{{ session()->get('newImage') }}" class="max-w-48 max-h-48 sm:max-w-72 sm:max-h-72 mb-2 ">
                          <button id="fileSelect" type="button" class="bg-gray-500 hover:bg-gray-400 text-white rounded px-4 py-2">画像を選択</button>
                          <input type="file" id="image" name="image" style="display:none" onchange="previewImage(this);">
                          <input type="hidden" name="post[new_image_path]" value="{{ session()->has('newImage') ? session()->get('newImage') :"" }}">
                          <p class="error">{{$errors->first('image')}}</p>
                          <!--
                          基本的にcreateと同じだが、preImageとnewImageを使い分ける必要があったので、Controllerで処理を変えてる。
                          あとは同じ。
                          -->
                        </div>
                      </div>
                    </section>
                  </div>
                  
                  <h2 class="underline underline-offset-4 decoration-orange-700 mt-4">タグ</h2>
                  <div class="grid gap-1 grid-cols-3 p-3">
                    <div class="mb-4">
                      <label class="block text-gray-700 dark:text-gray-400 text-md font-bold mb-2" for="pair">
                          場所:
                      </label>
                      <select name="tag[]" class="js-example-basic-multiple", style="width: 100%" data-placeholder="Select a tag..." data-allow-clear="false" multiple="multiple" title="Select tag..." >
                        @foreach($tags_spot as $tag)
                          <option value="{{$tag->id}}" {{ in_array($tag->id, $post->tags->pluck('id')->toArray()) ? "selected":"" }}>{{$tag->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="block text-gray-700 dark:text-gray-400 text-md font-bold mb-2" for="pair">
                          自然:
                      </label>
                      <select name="tag[]" class="js-example-basic-multiple", style="width: 100%" data-placeholder="Select a tag..." data-allow-clear="false" multiple="multiple" title="Select tag..." >
                        @foreach($tags_nature as $tag)
                          <option value="{{$tag->id}}" {{ in_array($tag->id, $post->tags->pluck('id')->toArray()) ? "selected":"" }}>{{$tag->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-4">
                      <label class="block text-gray-700 dark:text-gray-400 text-md font-bold mb-2" for="pair">
                        動物:
                      </label>
                      <select name="tag[]" class="js-example-basic-multiple", style="width: 100%" data-placeholder="Select a tag..." data-allow-clear="false" multiple="multiple" title="Select tag..." >
                        @foreach($tags_animal as $tag)
                            <option value="{{$tag->id}}" {{ in_array($tag->id, $post->tags->pluck('id')->toArray()) ? "selected":"" }}>{{$tag->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <h2 class="underline underline-offset-4 decoration-orange-700 mb-2">撮影場所</h2>
                    <div class="rounded-lg h-96 overflow-hidden">
                      <input
                          id="pac-input"
                          class="controls"
                          type="text"
                          placeholder="Search Box"
                        />
                      <div id="map" class="object-cover object-center h-full w-full"></div>
                    </div>
                    <div class="flex flex-col justify-start sm:flex sm:flex-row mt-2">
                      <input id="lat" name="post[latitude]" type="hidden" class="rounded-lg bg-gray-100 border-0" value="{{$post->latitude}}">
                      <input id="lng" name="post[longitude]" type="hidden" class="rounded-lg bg-gray-100 border-0" value="{{$post->longitude}}">
                    </div>
                    <div class="flex justify-between">
                      <div>
                        <a href="{{url()->previous()}}" class="text-indigo-500 inline-flex items-center mt-6">back</a>
                      </div>
                      <div>
                        <input type="submit" class="lg:mr-6 mt-2 bg-gray-800 hover:bg-gray-700 text-white text-md rounded px-4 py-2" value="保存">
                      </div>
                    </div>
                      
                </form>
              </div>          
            </div>
          </div>
        </div>
        <script src="https://maps.googleapis.com/maps/api/js?key={{config('services.googleMap.apikey')}}&callback=initAutocomplete&libraries=places&v=weekly"defer></script>

        <script>
          function initAutocomplete($post) {
            const map = new google.maps.Map(document.getElementById("map"), {
              center: { lat: {{$post->latitude === null ? 35.6812362: $post->latitude }}, lng: {{$post->longitude === null ? 139.7671248:$post->longitude}} },
              zoom: 13,
              mapTypeId: "roadmap",
            });
            
            // マーカーを初期位置に追加
            const initialMarker = new google.maps.Marker({
                map,
                position: { lat: {{$post->latitude === null ? 35.6812362: $post->latitude }}, lng: {{$post->longitude === null ? 139.7671248:$post->longitude}} },
                title: "initialPosition"
            });
            
            
            // Create the search box and link it to the UI element.
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);
            
          
            
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
            const fileSelect = document.getElementById("fileSelect");
            const image = document.getElementById("image");
            
            fileSelect.addEventListener("click", (e) => {
              if (image) {
                image.click();
              }
            }, false);
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