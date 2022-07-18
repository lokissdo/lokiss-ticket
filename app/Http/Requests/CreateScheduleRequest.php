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
    private function convert_HHMM_tominutes($str){
        $arr=explode(':',$str);
        if(count($arr) < 2) return -1;
        return intval($arr[0])*60+intval($arr[1]);
    }
    protected function prepareForValidation()
    {
        $array=array_diff($this->station_id, [null]);
        $this->merge([
                        'arrival_time'=>$this->convert_HHMM_tominutes($this->arrival_time),
                        'departure_time'=>$this->convert_HHMM_tominutes($this->departure_time),
                        'station_id'=>$array,
                    ]);
        
        // if($this->address!='null' && $this->address2!='null' ){
        //     $user =DB::table('districts')
        //                     ->where('code', '=', $this->address2)
        //                     ->where('province_code', '=', $this->address)
        //                     ->get();
        //     if($user===null){
        //         $this->merge([
        //             'address'=>'INVALID',
        //             'address2'=>'INVALID',
        //         ]);
        //     }
        // }

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
                Rule::exists(Province::class,'code'),
            ],
            'arrival_province_code' => [
                'bail',
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if ($value === 'null')
                        $fail('Tỉnh phải được chọn.');
                },
                Rule::exists(Province::class,'code'),
            ],
            'departure_time' => [
                'bail',
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if ($value == -1 || $value <= 0 || $value > 1440 )
                        $fail("Thời gian khởi hành không hợp lệ");
                },
            ],
            'arrival_time' => [
                'bail',
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if ($value == -1 ||  $value <= 0|| $value > 1440)
                        $fail("Thời gian đến không hợp lệ");
                },
            ],
            'total_days' => [
                'bail',
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    if ($value < 0 || ($value == 0 && $this->arrival_time <= $this->departure_time) || $value > 20)
                        $fail("Thời gian di chuyển không hợp lệ");
                },
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
                    if(count($value) < 2) {
                        $fail('Vui lòng thêm bến xe');
                        return;
                    }
                 foreach($value as $one){
                    if(!Station::find($one)) {
                        $fail('Pls dont do that');
                        break;
                    }
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
        ];
    }
    public function attributes(): array
    {
        return [
            'total_days'   => 'Tổng số ngày di chuyển',
            'station_id' => 'Bến xe',
        ];
    }
}
