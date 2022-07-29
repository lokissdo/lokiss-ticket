<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TripRegisteringRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'address' => [
                'bail',
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if ($value === 'null')
                        $fail('Tỉnh phải được chọn.');
                    else if($value==='INVALID')
                        $fail('Tỉnh không hợp lệ.');
                },
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'required' => ':attribute bắt buộc phải điền',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên',
            'address'=> 'Tỉnh',
            'address2'=> 'Quận huyện',
        ];
    }
}
