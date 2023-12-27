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
                                    <option value="{{$category->id}}"{{ $category->id === $post->category_id ? "selected":"" }}>{{$category->name}}</option>
                                @endforeach
                                
                            </select>
                            
                            <h2>tag</h2>
                            @foreach($tags as $tag)
                                <input type="checkbox" name="tag[]" value="{{$tag->id}}" {{ in_array($tag->id, $post->tags->pluck('id')->toArray()) ? 'checked' : '' }}><label>{{$tag->name}}</label>
                                <!--
                                {{in_array()?'checked':''}}これの?以降で場合分け。trueならchecked、falseなら''を返す
                                in_array(探したい値, 配列)で配列の中に探したい値があればtrue、なければfalseを返す
                                やりたいことは「このタグのidってこのポストが持つタグのidと一致してますか？」ということなので
                                1.探したい値にこのタグのid、配列にこの投稿の持つタグのidを持ってくる
                                2.この投稿の持つタグのidは$postでこの投稿を取得
                                3.tagsでこの投稿が持つタグにアクセス、
                                4.pluck('id')でアクセスした先のデータからidだけ取得 https://qiita.com/jacksuzuki/items/eae943735bda747be09c
                                5.toArrayで配列に変換している。
                                -->
                            @endforeach
                            
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
        
        
    </body>
    
    </x-app-layout>
</html>