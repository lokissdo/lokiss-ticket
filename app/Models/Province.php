<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $primaryKey = 'code';
    public function getShortNameAttribute()
    {
        $preFix = array('Tỉnh', 'Thành phố');
        $name = $this->name;
        $short_name=str_replace($preFix, "", $name);
        return trim($short_name) ;
    }
}
