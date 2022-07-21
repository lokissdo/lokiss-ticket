<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;
    protected $appends = ['province_name','district_name'];
    public function getProvinceNameAttribute()
    {
        $preFix = array('Tỉnh', 'Thành phố');
        $name = Province::where('code', $this->address)->first()->name;
        // $arrStr=explode(" ",$name);
        // $res=implode(" ",$arrStr);
        return str_replace($preFix, "", $name);
    }
    public function getDistrictNameAttribute()
    {
        $preFix = array('Quận', 'Huyện', 'Thị xã');

        $name = District::where('code', $this->address2)->first()->name;
        // $arrStr=explode(" ",$name);
        // $res=implode(" ",$arrStr);
        return str_replace($preFix, "", $name);
    }
    static function OrderStations($list)
    {
        $map = [];
        $res=[];
        $first=NULL;
        foreach($list as $each){
            $each['is_first']=true;
            $map[$each['station_id']]=$each;
        }
        foreach($map as $each){
           if($each['next_station_id']!=null){
            $map[$each['next_station_id']]['is_first']=false;
           }
        }
        foreach($map as $each){
            if($each['is_first']==true){
                $first=$each;
                break;
            }
        }
        while(true){
            $res[]=$first;
            if($first['next_station_id']==null) break; 
            $first=$map[$first['next_station_id']];
        }
        return $res;
    }
}
