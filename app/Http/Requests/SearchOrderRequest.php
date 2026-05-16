<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_name'  => ['nullable','string','max:100'],
            'date_from'  => ['nullable','date'],
            'date_to'    => ['nullable','date','after_or_equal:date_from'],
            'min_total'  => ['nullable','integer','min:0'],
            'max_total'  => ['nullable','integer','min:0','gte:min_total'],
        ];
    }

    public function messages(): array
    {
        return [
            'date_to.after_or_equal' => '終了日は開始日以降を指定してください。',
            'max_total.gte'          => '最大金額は最小金額以上を指定してください。',
        ];
    }
}
