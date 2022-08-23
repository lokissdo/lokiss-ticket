<?php

namespace App\Exports;

use App\Models\Coach;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;

class CoachExport implements FromView
{
    private $service_provider_id;
   public function __construct($service_provider_id)
   {
       $this->service_provider_id=$service_provider_id;
   }
    public function view(): View
    {
        $coaches= Coach::where('service_provider_id',$this->service_provider_id)->get();
        $coaches->append('type_name');
        return view('exports.coach', [
            'coaches' => $coaches
        ]);
    }
}
