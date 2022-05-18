<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::get('http://provinces.open-api.vn/api/?depth=2');
        $data = json_decode($response);
        $toInsert=[];
        foreach($data as $province){
            foreach($province->districts as $district){
                $toInsert[]=[
                    'name'=>$district->name,
                    'code'=>$district->code,
                    'province_code'=>$province->code,
                ];
            }
        }
        DB::table('districts')->insert($toInsert);
    }
}
