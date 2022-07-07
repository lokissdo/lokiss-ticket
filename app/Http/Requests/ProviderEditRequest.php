<?php

namespace App\Http\Requests;

use App\Enums\UserRoleEnum;
use App\Models\Province;
use App\Models\ServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProviderEditRequest extends FormRequest
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
            'name' => [
                'bail',
                'required',
                'string',
                'min:1',
                'max:255',
            ],
            'address' => [
                'bail',
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if ($value === 'null')
                        $fail('Tỉnh phải được chọn.');
                },
                Rule::exists(Province::class,'code'),
            ],
            'email' => [
                'bail',
                'required',
                'email',
                Rule::exists(User::class,'email'),
                'max:255',
                function ($attribute, $value, $fail) {
                    $employer = User::where('email',$value)->first();
                    $oldemployer=ServiceProvider::find($this->id);
                    if(!$oldemployer)  {
                        $fail('Dont do that');
                        return;
                    }
                    if($employer->role!=UserRoleEnum::PASSENGER && $employer->id!=$oldemployer->employer_id) $fail('Chủ của nhà xe phải tạo tài khoản chưa phân quyền.');
                },
            ],
            'phone_number' => [
                'bail',
                'required',
                'digits_between:10,11',
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'required'  =>  ':attribute bắt buộc phải điền.',
            'unique'    =>  ':attribute đã được đăng ký.',
            'exists'    =>  'Không tồn tại :attribute trong hệ thống.',
            'min'       =>  ':attribute phải có ít nhất :min ký tự.',
            'max'            =>  ':attribute phải có nhiều nhất :max ký tự.',
            'digits_between' =>':attribute chỉ có từ :min đến :max ký tự. ',
            'email'=>':attribute không hợp lệ.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên',
            'email'   => 'Email',
            'address'=> 'Tỉnh',
            'phone_number'=> 'Số điện thoại',
        ];
    }
}
