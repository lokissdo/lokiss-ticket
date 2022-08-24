<?php

namespace App\Http\Controllers\service_provider;

use App\Models\Rating;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SP_IndexController extends Controller
{
    private $service_provider_id;

    public function __construct()
    {
        if (session()->has('user'))
            $this->service_provider_id = session()->get('user')['service_provider_id'];
    }
    public function index()
    {

        $chartjs=ServiceProvider::weekly_revenue_line($this->service_provider_id);
        $ratings=Rating::get_comments_by_service_provider($this->service_provider_id);
        $avgAndCountArr=Rating::get_general_ratings_by_service_provider_list([$this->service_provider_id]);
        $avgAndCount=reset($avgAndCountArr);
        return view('service_provider.index', compact('chartjs'))->with([
            'ratings'=>$ratings,
            'avgAndCount'=>$avgAndCount
        ]);
    }
}
