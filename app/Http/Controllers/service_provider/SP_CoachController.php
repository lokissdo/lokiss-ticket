<?php

namespace App\Http\Controllers\service_provider;

use App\Exports\CoachExport;
use App\Models\Coach;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class SP_CoachController extends Controller
{
    private $service_provider_id;


    public function __construct()
    {
        if (session()->has('user'))
            $this->service_provider_id = session()->get('user')['service_provider_id'];
    }
    public function coach_index()
    {
        View::share('title', 'Coaches');
        $coaches = Coach::where('service_provider_id', $this->service_provider_id)->get();
        $coaches->append('type_name');
        return view('service_provider.coach.index', [
            'coaches' => $coaches->toArray(),
        ]);
    }
    public function coach_export()
    {
        return Excel::download(new CoachExport($this->service_provider_id), 'coachess.xlsx');
         
    }

}
