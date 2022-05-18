<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::get('http://provinces.open-api.vn/api/?depth=1');
        $data = json_decode($response);
        $toInsert=[];
        foreach($data as $address){
            $toInsert[]=[
                'name'=>$address->name,
                'code'=>$address->code,
            ];
        }
        DB::table('provinces')->insert($toInsert);
    }
}
