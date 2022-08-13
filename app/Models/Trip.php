<?php

namespace App\Models;

use App\Constants\ItemsPerPage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Ramsey\Collection\Set;

class Trip extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'price',
        'departure_date',
        'schedule_id',
        'service_provider_id',
        'coach_id'

    ];
    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
    public function service_provider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }
    static function get_trip($service_provider_id, $trip_id = null)
    {
        $trip = Trip::where('service_provider_id', $service_provider_id)->find($trip_id);
        $trip->get_necessary_informations_trip();
        return $trip->toArray();
    }
    static function get_service_provider_ids_list( array $tripsArray)
    {
        $list = [];
        foreach ($tripsArray as $item) {
            $list[] = $item['service_provider']['id'];
        }
        return array_unique($list);
    }
    static function get_schedule_ids_list(array $tripsArray)
    {
        $list = array_column($tripsArray,'schedule_id');
        return array_unique($list);
    }
    static function get_trips($service_provider_id = null, $request = null,  $isIncludeTotalPage = true)
    {

        // Get API
        $itemsPerPage = ItemsPerPage::TRIP;
        $sortCol = $request->sortCol ?? 'id';
        $sortType = $request->sortType ?? 'asc';
        $offset = isset($request->pageNum) && $request->pageNum ? ($request->pageNum - 1) * $itemsPerPage : 0;


        $departure_province_code = $request->departure_province_code ?? null;
        $arrival_province_code = $request->arrival_province_code ?? null;
        $coach_id = $request->coach_id ?? null;
        $departure_date = $request->departure_date ?? null;
        $isIncludeTotalPage = ($isIncludeTotalPage && (!empty($request->isFilter) || !isset($request->isFilter))) ? 1 : 0;

        /////Filter
        $query = Trip::query();
        if ($service_provider_id)
            $query->where('trips.service_provider_id', $service_provider_id);
        else $query->with('service_provider:id,name');

        if ($departure_province_code != null && $departure_province_code != 'null')
            $query->whereHas('schedule', function (Builder $queryTemp) use ($departure_province_code) {
                $queryTemp->where('departure_province_code', $departure_province_code);
            });



        if ($arrival_province_code != null && $arrival_province_code != 'null')
            $query->whereHas('schedule', function (Builder $queryTemp) use ($arrival_province_code) {
                $queryTemp->where('arrival_province_code', $arrival_province_code);
            });
        if (!empty($coach_id))        $query->where('coach_id', $coach_id);
        if (!empty($departure_date))  $query->where('departure_date', $departure_date);


        //totalPage if not sorting
        $totalPage = $isIncludeTotalPage ? ceil(($query->count()) / $itemsPerPage) : -1;

        //sort
        if ($sortCol == 'duration') 
            $query->join('schedules', 'trips.schedule_id', '=', 'schedules.id')
                ->orderBy('schedules.duration', $sortType)
                ->select('trips.*');
         else $query->orderBy($sortCol, $sortType);

        //Retrieve
        $trips = $query->offset($offset)->limit($itemsPerPage)->with(['coach', 'schedule.arrival_province', 'schedule.departure_province'])->get();

        $trips = $trips->map(function ($item) {
            $item->get_necessary_informations_trip();
            return $item;
        });

        return [
            'trips' => $trips->toArray(),
            'total_page' => $totalPage,
        ];
    }
    private function get_necessary_informations_trip()
    {
        $this->schedule->get_informations_without_detail();
        $this->coach =
            [
                'name' => $this->coach->name,
                'seat_number' => $this->coach->seat_number,
                'photo' => $this->coach->photo
            ];
        unset(
            $this->coach_id,
            $this->service_provider_id,
            $this->schedule->id,
            $this->schedule->service_provider_id,
        );
    }
}
