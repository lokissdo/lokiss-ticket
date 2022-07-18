<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;
    public function getProvinceNameAttribute()
    {
        $preFix=array('Tỉnh','Thành phố');
        $name=Province::where('code', $this->address)->first()->name;
        // $arrStr=explode(" ",$name);
        // $res=implode(" ",$arrStr);
        return str_replace($preFix,"",$name);
    }
    public function getDistrictNameAttribute()
    {
        $preFix=array('Quận','Huyện','Thị xã');

        $name = District::where('code', $this->address2)->first()->name;
        // $arrStr=explode(" ",$name);
        // $res=implode(" ",$arrStr);
        return str_replace($preFix,"",$name);

    }
   
}
