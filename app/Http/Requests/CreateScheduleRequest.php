<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Province;
use App\Models\User;
use App\Enums\UserRoleEnum;
use App\Models\Station;

class CreateScheduleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    protected function prepareForValidation()
    {
        $array = array_diff($this->station_id, [null]);
        $this->merge([
            'station_id' => $array,
        ]);

    }
    public function rules()
    {
        return [
            'departure_province_code' => [
                'bail',
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if ($value === 'null')
                        $fail('Tỉnh phải được chọn.');
                },
                Rule::exists(Province::class, 'code'),
            ],
            'arrival_province_code' => [
                'bail',
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if ($value === 'null')
                        $fail('Tỉnh phải được chọn.');
                },
                Rule::exists(Province::class, 'code'),
            ],
            'departure_time' => [
                'bail',
                'required',
                'string',
                'date_format:H:i',
    
            ],
            'duration' => [
                'bail',
                'required',
                'numeric',
                'min:10',
                'max:20000'
            ],
            'station_id' => [
                'bail',
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    if (count($value) !== count(array_flip($value))) {
                        $fail('Pls dont do that');
                        return;
                    }
                    if (count($value) < 2) {
                        $fail('Vui lòng thêm bến xe');
                        return;
                    }
                    foreach ($value as $one) {
                        if (!Station::find($one)) {
                            $fail('Pls dont do that');
                            break;
                        }
                    }
                    $first = Station::find($value[0]);
                    $last = Station::find($value[count($value) - 1]);
                    if ($first->address != $this->departure_province_code || $last->address != $this->arrival_province_code) {
                        $fail('Bến xe khởi hành và đến phải thuộc tỉnh khởi hành và đến');
                    }
                },
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'required'  =>  ':attribute bắt buộc phải điền.',
            'numeric'  => "Don't do that bruhhh",
            'duration.min'    => ':attribute phải lớn hơn :min phút',
            'duration.max' => ':attribute phải nhỏ hơn :max phút',
        ];
    }
    public function attributes(): array
    {
        return [
            'duration'   => 'Thời gian di chuyển',
            'station_id' => 'Bến xe',
            'departure_time'=>"Thời gian khởi hành"
        ];
    }
}
