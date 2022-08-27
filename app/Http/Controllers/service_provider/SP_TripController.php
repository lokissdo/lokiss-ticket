<?php

namespace App\Http\Controllers\service_provider;

use App\Http\Requests\TripRegisteringRequest;
use App\Imports\TripsImport;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use App\Models\Ticket;
use App\Models\Trip;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
class SP_TripController extends Controller
{
    private $service_provider_id;

    public function __construct()
    {
        if (session()->has('user'))
            $this->service_provider_id = session()->get('user')['service_provider_id'];
    }
    public function trip_index(Request $request)
    {
        View::share('title', 'Trip');
        $tripsData = Trip::get_trips($this->service_provider_id, $request);
        if (!empty($request->isAPI)) return json_encode($tripsData);
        return view('service_provider.trip.index')->with($tripsData);
    }
    public function trip_create(int $id)
    {
        if (Schedule::where('id', $id)->where('service_provider_id', $this->service_provider_id)->doesntExist())
            return back()->withError('Bạn không có quyền truy cập vào trang này');
        View::share('title', 'TripCreation');
        return view('service_provider.trip.create', ['id' => $id]);
    }
    public function trip_store(TripRegisteringRequest $request)
    {
        $newTrip = $request->toArray();
        $newTrip['service_provider_id'] = $this->service_provider_id;
        return Trip::create($newTrip);
    }
    public function trip_destroy(int $id)
    {
        try {
            Trip::find($id)->delete();
        } catch (Exception $e) {
            return back()->withError('Không thể xóa chuyến đi này vì đã có người mua vé'); //$e->getMessage()
        }
        return redirect()->route('serviceprovider.trip.index');
    }
    public function trip_show(int $id)
    {
        View::share('title', 'Trip');
        //Schedule
        $trip = Trip::get_trip($this->service_provider_id, $id);
        if(!$trip) return redirect()->back();
        $scheduleDetail = ScheduleDetail::get_schedule_detail($trip['schedule_id']);
        $ticketsArr = Ticket::get_tickets($id);
        return view("service_provider.trip.show")->with([
            'scheduleDetail' => $scheduleDetail,
            'tickets' => $ticketsArr,
            'trip' => $trip,
        ]);
    }
    public function trip_import()
    {
        View::share('title', 'TripCreation');
        return view('service_provider.trip.import');
    }
    public function trip_importing(Request $request)
    {

        try {
            Excel::import(new TripsImport($this->service_provider_id), $request->file('trips_file'));
        } catch (ValidationException $e) {
            $failures = $e->failures();
            return $failures;
        }
        return 1;
    }
    public function trip_export_byseat(int $id)
    {
        $trip=Trip::get_trip($this->service_provider_id,$id);
        if(!$trip) return;
        $ticketsArr = Ticket::get_tickets($id);
        $pdf = Pdf::loadView('exports.trip_byseat', [
            'trip'=>$trip,
            'tickets'=>$ticketsArr
        ]);
        return $pdf->download('trip_seats.pdf');
    }
    public function trip_export_bystation(int $id)
    {
        $trip=Trip::get_trip($this->service_provider_id,$id);
        if(!$trip) return;
        $ticketsArr = Ticket::get_tickets($id);
        $scheduleDetail = ScheduleDetail::get_schedule_detail($trip['schedule_id']);

        $pdf = Pdf::loadView('exports.trip_bystation', [
            'trip'=>$trip,
            'tickets'=>$ticketsArr,
            'scheduleDetail'=>$scheduleDetail
        ]);
        return $pdf->download('trip_station.pdf');
    
    }
}

