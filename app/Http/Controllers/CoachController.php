<?php

namespace App\Http\Controllers;

use App\Enums\CoachTypesEnum;
use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CoachController extends Controller
{
    public function get_coaches(Request $req)
    {
        $user = session()->get('user');
        if (!$user) 
            return 0;

        $role = $user['role'];
        if ($role != 'employee' && $role != 'employer') 
            return 0;
        $numOfItem = 6;
        $query= Coach::where('service_provider_id',$user['service_provider_id'])->where('name', 'like', '%' . $req->value . '%');
        if(!isset($req->all)){
            $query->take($numOfItem);
        }
        $res =$query->get();
        if (!$res) return 0;
        $res->append('type_name');
        return $res;
    }
    public function get_coaches_types()
    {
        return json_encode(CoachTypesEnum::asArray());
    }
}
