<?php

namespace App\Exports;

use App\Models\Schedule;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;

class ScheduleExport implements FromView
{
   private $service_provider_id;
   public function __construct($service_provider_id)
   {
       $this->service_provider_id=$service_provider_id;
   }
    public function view(): View
    {
        $schedules= Schedule::get_schedules_list($this->service_provider_id);
        return view('exports.schedule', [
            'schedules' => $schedules
        ]);
    }
}
