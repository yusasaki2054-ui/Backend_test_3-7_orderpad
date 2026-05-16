<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => ['required','string','max:100'],
            'price'        => ['required','integer','min:0','max:10000000'],
            'description'  => ['nullable','string'],
            'published_at' => ['nullable','date','before_or_equal:today'],
            'image'        => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => '商品名は必須です。',
            'price.integer'  => '価格は整数で入力してください。',
            'image.image'    => '画像ファイルをアップロードしてください。',
            'image.mimes'    => '対応形式はjpg・jpeg・png・webpです。',
   
            'image.max'      => '画像サイズは2MB以内にしてください。',
        ];
    }
}
