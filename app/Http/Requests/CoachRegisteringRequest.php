<?php

namespace App\Http\Requests;

use App\Enums\CoachTypesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// Content-Type: 
//data-form => redirect 
//json/application => JSON
class CoachRegisteringRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'type' => [
                'bail',
                'required',
                'numeric',
                Rule::in(CoachTypesEnum::asArray()),
            ],
            'seat_number' => [
                'bail',
                'required',
                'numeric',
                'min:10',
                'max:50',
            ],
            'name' => [
                'bail',
                'required',
                'string',
                'min:1',
                'max:255',
            ],
            'photo' => [
                'bail',
                'required',
                'image',
                'max:2048'
            ],

        ];
    }
    public function messages(): array
    {
        return [
            'required'  =>  ':attribute bắt buộc phải điền.',
            'in'  => ':attribute phải hợp lệ',
            'max' => ':attribute không được lớn hơn :max ký tự',
            'photo.max' => ':attribute không được lớn hơn :max KB',
            'seat_number.max' => ':attribute không được lớn hơn :max chỗ'

        ];
    }
    public function attributes(): array
    {
        return [
            'name' => 'Tên',
            'seat_number' => 'Số chỗ ',
            'type' => 'Loại',
            'photo' => 'Ảnh'
        ];
    }
}
