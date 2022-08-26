<?php

namespace App\Http\Controllers\service_provider;

use App\Models\Rating;
use App\Models\ServiceProvider;
use App\Models\Ticket;
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

        $chartWeek=ServiceProvider::weekly_revenue_line($this->service_provider_id);
        $chartDay=ServiceProvider::daily_analyst_line($this->service_provider_id);
        $revenues=ServiceProvider::revenue_numbers($this->service_provider_id);
        $totalTickets=Ticket::serviceprovider_total_tickets($this->service_provider_id);
        $ratings=Rating::where('service_provider_id',$this->service_provider_id)->with('user:id,name,avatar')->orderBy('created_at','desc')->get();
        $avgAndCountArr=Rating::get_general_ratings_by_service_provider_list([$this->service_provider_id]);
        $avgAndCount=reset($avgAndCountArr);
        return view('service_provider.index', compact(['chartWeek','chartDay']))->with([
            'ratings'=>$ratings,
            'avgAndCount'=>$avgAndCount,
            'revenues'=>$revenues,
            'totalTickets'=>$totalTickets
        ]);
    }
}
