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
        
        <style>
            .error{
                color:red;
                font-weight:bold
            }
        </style>

        
    </head>
    
    <body onload="selected({{$post->category_id}})">
    <!--
    このonloadでカテゴリーの初期値をもともと選択していたカテゴリーにする。
    下のほうにjavascriptが書いてある。
    selected({{$post->category_id}})で関数に投稿のcategory_idを受け渡ししている。
    -->
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form action="/posts/{{$post->id}}/edit" method="POST">
                        @csrf
                        @method('PUT')
                            <h2>投稿タイトル</h2>
                            <input type="text" name="post[title]" value="{{ old('post.title',$post->title) }}">
                            <p class="error">{{$errors->first('post.title')}}</p>
                            <!--
                            nameで指定した入れ子の構造（post[title]）は
                            それ以降は「.（ドット）」で繋いで取り出すことができる
                            -->
                            
                            <h2>写真説明</h2>
                            <textarea name="post[body]">{{ old('post.body',$post->body) }}</textarea>
                            <p class="error">{{$errors->first('post.body')}}</p>
                            
                            <h2>カテゴリー</h2>
                            <select id="category" name="post[category_id]">
                               
                                 @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                                
                                
                            </select>
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
        <script>
            function selected(id){ 
                //selected(id)のidはonloadのところでもらってきたcategory_idのこと
                select = document.getElementById('category').options;
                //htmlの方のセレクトボックスにつけたid='category'の内容を取得し、
                //さらに.optionsでoptionの内容を取得。selectという値に配列として格納している。
                
                for(let i = 0; i < select.length; i++){
                    if(select[i].value == id){
                        //select[i].value == idのところは===にすると動かない
                        //厳密一致(===)にするとダメな理由はわからない
                        
                        select[i].selected = true;
                        break;
                    
                    }
                //if文でselectに格納された配列に対して0から順に配列の中身のvalueについてidと一致するか検証※ここのidはcategor y_idのこと
                //一致すればtrueが返るのでif内の関数が実行される
                //if内の関数はその時のselectの配列番号の内容をselected（初期値）にするという意味。
                //参考：https://teratail.com/questions/123775
                }
            }
            
           
        /*
             window.onload = function() {
                select = document.getElementById('category').options;
                for(let i = 0; i < select.length; i++ ){
                    if(select[i].value === '3'){
                        select[i].selected = true;
                        break;
                    }
                }
            }   
        
        */    
        </script>
    </body>
    
    </x-app-layout>
</html>
