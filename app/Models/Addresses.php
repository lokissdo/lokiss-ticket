<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    use HasFactory;
    public function get_detail_addresses(){
        $content=[];
        $allProvince=Province::all();
        $allDistrict=District::all();
        foreach($allDistrict as $district){
            $districts[$district->province_code][]=[
                'code'=>$district->code,
                'name'=>$district->name,
            ];
        }
        foreach($allProvince as $item){
            $content[]=[
                'code'=>$item->code,
                'name'=>$item->name,
                'districts'=>$districts[$item->code],
            ];    
        }
        return response()->json($content);
    }
}
