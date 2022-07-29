<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;
    protected $with = ['province','district'];
    protected $appends = ['province_name','district_name'];

    protected $fillable = [
        'name',
        'address',
        'address2',

    ];
    public $timestamps = false;
    public function province(){
        return $this->hasOne(Province::class,'code','address'); 
    }
    public function district(){
        return $this->hasOne(District::class,'code','address2'); 
    }
    public function getProvinceNameAttribute()
    {
        $preFix = array('Tỉnh', 'Thành phố');
        $name = $this->province->name;
        // $arrStr=explode(" ",$name);
        // $res=implode(" ",$arrStr);
        return str_replace($preFix, "", $name);
    }
    public function getDistrictNameAttribute()
    {
        $preFix = array('Quận', 'Huyện', 'Thị xã','Thành phố');

        $name = $this->district->name;
        // $arrStr=explode(" ",$name);
        // $res=implode(" ",$arrStr);
        return str_replace($preFix, "", $name);
    }
    static function OrderStations($list)
    {
        $map = [];
        $res=[];
        $first=NULL;

        //initial marking map
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
