<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
class AuthenticatingRequest extends FormRequest
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
    protected function prepareForValidation()
    {

    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => [
                'bail',
                'required',
                'string',
            ],
            'email' => [
                'bail',
                'required',
                'email',
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'required' => ':attribute bắt buộc phải điền.',
            'string'=>':attribute phải là chuỗi.',
        ];
    }

    public function attributes(): array
    {
        return [
            'password'=> 'Mật khẩu',
            'email'   => 'Email',
        ];
    }

}
