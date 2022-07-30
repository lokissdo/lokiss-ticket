<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Enums\UserRoleEnum;

class AddEmployeeRequest extends FormRequest
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
            'email' => [
                'bail',
                'required',
                'email',
                Rule::exists(User::class,'email'),
                'max:255',
                function ($attribute, $value, $fail) {
                    $role = User::where('email',$value)->first()->role;
                    if($role!=UserRoleEnum::PASSENGER) $fail("Nhân viên tạo tài khoản chưa phân quyền.");
                },
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'required'  =>  ':attribute bắt buộc phải điền.',
            'exists'    =>  'Không tồn tại :attribute trong hệ thống.',
            'email'=>':attribute không hợp lệ.',
        ];
    }

    public function attributes(): array
    {
        return [
            'email'   => 'Email',
        ];
    }

}

