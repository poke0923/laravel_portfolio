<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
            'post.title' => 'required|max:50',
            'post.body' => 'max:200',
            
            //
        ];
    }
    
    public function messages()
    {
        return [
            
            'post.title.required' => 'タイトルは必ず入力してください。写真を更新する場合は再選択してください。',
            'post.title.max' => 'タイトルは50文字以内で入力してください。写真を更新する場合は再選択してください。',
            'post.body.max' => '写真説明は200文字以内で入力してください。写真を更新する場合は再選択してください。',
            
        ];
    }
    
}
