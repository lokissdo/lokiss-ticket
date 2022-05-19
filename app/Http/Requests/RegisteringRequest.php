<?php

namespace App\Http\Requests;

use App\Models\District;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
class RegisteringRequest extends FormRequest
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
        if($this->address!='null' && $this->address2!='null' ){
            $user =DB::table('districts')
                            ->where('code', '=', $this->address2)
                            ->where('province_code', '=', $this->address)
                            ->get();
            if($user===null){
                $this->merge([
                    'address'=>'INVALID',
                    'address2'=>'INVALID',
                ]);
            }
        }

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
                'min:6',
                'max:25',
            ],
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
                    else if($value==='INVALID')
                        $fail('Tỉnh không hợp lệ.');
                },
            ],
            'address2' => [
                'bail',
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if ($value === 'null')
                        $fail('Quận huyện phải được chọn.');
                    else if($value==='INVALID')
                        $fail('Quận huyện không hợp lệ.');
                },

            ],
            'email' => [
                'bail',
                'required',
                Rule::unique(User::class,'email'),
                'email',
                'max:255',
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'required' => ':attribute bắt buộc phải điền',
            'unique'   => ':attribute đã được đăng ký',
            'exists'    => ':attribute không hợp lệ',
            'min'    => ':attribute phải có ít nhất :min ký tự',
            'max'=>':attribute phải có nhiều nhất :max ký tự',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên',
            'password'=> 'Mật khẩu',
            'email'   => 'Email',
            'address'=> 'Tỉnh',
            'address2'=> 'Quận huyện',
        ];
    }

}
