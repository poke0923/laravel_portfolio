<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
 
    return [
        //post[title]などで指定した入れ子の構造は「.（ドット）」で繋いで取り出す
        'post.title' => 'required',
        'post.body' => 'required|min:10',
    ];
    }
    
    public function attributes()
    {
    return [
        'post.title' => 'タイトル',
        'post.body' => '本文'
    ];
    }
}