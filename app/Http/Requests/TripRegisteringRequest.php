<?php

namespace App\Http\Requests;

use App\Models\Coach;
use App\Models\Schedule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TripRegisteringRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'price' => str_replace(',', '', $this->price),
        ]);
    }
    public function rules()
    {
        return [
            'schedule_id' => [
                'bail',
                'required',
                function ($attribute, $value, $fail) {
                    $service_provider_id = session()->get('user')['service_provider_id'];
                    if (empty($service_provider_id))  $fail('Pls dont do that');
                    if (!(Schedule::where('id', $value)->where('service_provider_id', $service_provider_id)->exists())) {
                        $fail('Pls dont do that. ');
                    }
                },
            ],
            'coach_id' => [
                'bail',
                'required',
                Rule::exists(Coach::class, 'id')
            ],
            'departure_date' => [
                'bail',
                'required',
                'date',
                'after_or_equal:today'
            ],
            'price' => [
                'bail',
                'required',
                'numeric',
                'min:0'
            ]
        ];
    }
    public function messages(): array
    {
        return [
            'required' => ':attribute bắt buộc phải điền.',
            'after_or_equal' => ':attribute phải hợp lệ.'
        ];
    }
    public function attributes(): array
    {
        return [
            'departure_date' => 'Ngày khởi hành',
            'price' => 'Giá thành'
        ];
    }
}
