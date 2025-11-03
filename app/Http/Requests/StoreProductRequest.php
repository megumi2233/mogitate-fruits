<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // 今回は認可チェック不要なので true
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:225', // 商品名：最大225文字に変更
            'price' => 'required|numeric|min:0|max:10000',
            'seasons' => 'required|array',
            'seasons.*' => 'exists:seasons,id',
            'description' => 'required|string|max:120',
            'image' => 'required|mimes:png,jpeg|max:1024', // 商品画像：1MB = 1024KB
        ];
    }

    public function messages(): array
    {
        return [
            // 商品名
            'name.required' => '商品名を入力してください',

            // 値段
            'price.required' => '値段を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.min' => '0~10000円以内で入力してください',
            'price.max' => '0~10000円以内で入力してください',

            // 季節
            'seasons.required' => '季節を選択してください',
            'seasons.*.exists' => '不正な季節が選択されました',

            // 商品説明
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',

            // 商品画像
            'image.required' => '商品画像を登録してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'image.max' => '画像は1MB以内でアップロードしてください',
        ];
    }
}
