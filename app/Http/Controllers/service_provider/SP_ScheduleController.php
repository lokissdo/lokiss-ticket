<?php /** @noinspection ALL */

namespace App\Http\Controllers\service_provider;

use App\Exports\ScheduleExport;
use App\Http\Requests\CreateScheduleRequest;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class SP_ScheduleController extends Controller
{
    private $service_provider_id;
    public function __construct()
    {
        if (session()->has('user'))
            $this->service_provider_id = session()->get('user')['service_provider_id'];
    }
    public function schedule_index()
    {
        View::share('title', 'Schedules');

        //Schedule
        $schedules = Schedule::get_schedules_list($this->service_provider_id);
        return view("service_provider.schedule.index")->with([
            'schedules' => $schedules,
        ]);
    }
    public function schedule_show(int $id)
    {
        View::share('title', 'Schedules');
        //Schedule
        $schedule = Schedule::get_schedules_list($this->service_provider_id, $id)[0];
        return view("service_provider.schedule.show")->with([
            'schedule' => $schedule,
        ]);
    }
    public function schedule_create()
    {
        View::share('title', 'ScheduleCreation');
        return view('service_provider.schedule.create');
    }
    public function schedule_store(CreateScheduleRequest $request)
    {
        $toInsert = $request->except('station_id');
        $toInsert['service_provider_id'] = $this->service_provider_id;
        $schedule = Schedule::create($toInsert);
        if (!$schedule) return 0;
        $schedules_detail = [];
        $arrStations = $request->station_id;
        $i = 0;
        for (; $i < count($arrStations) - 1; ++$i) {
            $schedules_detail[] = [
                'schedule_id' => $schedule->id,
                'station_id' => $arrStations[$i],
                'next_station_id' => $arrStations[$i + 1],
            ];
        }
        $schedules_detail[] = [
            'schedule_id' => $schedule->id,
            'station_id' => $arrStations[$i],
            'next_station_id' => NULL,
        ];
        ScheduleDetail::insert($schedules_detail);
        return 1;
    }
    public function schedule_destroy(int $id)
    {
        try {
            ScheduleDetail::where('schedule_id', $id)->delete();
            Schedule::find($id)->delete();
        } catch (Exception $e) {
            return back()->withError('Không thể xóa lịch trình này vì đã được chọn trong chuyến đi'); //$e->getMessage()
        }
        return redirect()->route('serviceprovider.schedule.index');
    }
    public function schedule_export()
    {
        return Excel::download(new ScheduleExport($this->service_provider_id), 'schedules.xlsx');
         
    }
}
