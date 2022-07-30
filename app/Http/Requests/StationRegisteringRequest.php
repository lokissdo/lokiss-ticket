<?php

namespace App\Http\Requests;

use App\Models\District;
use Illuminate\Foundation\Http\FormRequest;

class StationRegisteringRequest extends FormRequest
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
            $user =District::where('code', '=', $this->address2)
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
            ]
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
