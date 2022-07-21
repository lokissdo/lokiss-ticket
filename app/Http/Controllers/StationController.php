<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class StationController extends Controller
{
    public function getAllStations(Request $req)
    {
        $limit = 6;
        $preVals = explode(',', $req->preVal);
        $query = Station::where('name', 'like', '%' . $req->value . '%');
        foreach ($preVals as $one)
            $query = $query->where('id', '!=', $one);
        $res = $query->take($limit)->get();
        if (!$res) return 0;
        return $res;
    }
}
