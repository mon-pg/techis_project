<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:100',
            'type' => 'required',
            'salesStatus' => 'required',
            'salesDate' => 'required|date',
            'detail' => 'nullable|max:300',
            'stock' => 'required',
            'sdStock' => 'required',
            'memo' => 'max:60',
        ];
    }
     /**
     * バリデーションの前処理を定義
     *
     * @return void
     */
    public function prepareForValidation()
    {
        // stockとsdStockに入力があれば、かなの全角を半角に変換
        if (isset($this->stock)) {
            $this->merge([
                'stock' => mb_convert_kana($this->stock, 'n')
            ]);
        }
        if (isset($this->sdStock)) {
            $this->merge([
                'sdStock' => mb_convert_kana($this->sdStock, 'n')
            ]);
        }
    }
}
