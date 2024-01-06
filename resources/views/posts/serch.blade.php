<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-app-layout>
    
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
                <div class="p-6 text-gray-900">
                    <!-- 検索機能ここから -->
                        <h1 class="mt-6 mb-3 underline underline-offset-4 decoration-orange-700 text-2xl">投稿検索</h1>
                        <div>
                            <form action="{{ route('index') }}" method="GET" class="text-sm bg-gray-100 border border-gray-200 rounded px-8 pt-6 pb-8 m-4">
                            @csrf
                                <input type="text" name="keyword">
                                <select name="category_id">
                                    <option value="0">すべて</option>
                                    
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{ $category->name }}</option>
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
                                <div class="flex justify-end">
                                <input type="submit" class=" bg-gray-900 hover:bg-gray-800 text-white rounded px-4 py-2" value="検索">
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
         
         
        
        
    </body>
    </x-app-layout>
</html>
