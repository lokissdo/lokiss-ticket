<?php

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;

class StationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $address2= $this->faker->randomElement(District::get());
        $preFix = array('Quận', 'Huyện', 'Thị xã', 'Thành phố');
        return [
            'name'=>'Ga '.str_replace($preFix, "", $address2->name),
            'address'=>$address2->province_code,
            'address2'=>$address2->code
        ];
    }
}
