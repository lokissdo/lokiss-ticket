<?php

namespace App\Models;

use App\Constants\ItemsPerPage;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
    static function get_trips($service_provider_id, $trip_id = null, $request = null)
    {
        $query = Trip::where('service_provider_id', $service_provider_id);


        // Get API
        $itemsPerPage = ItemsPerPage::TRIP;
        $sortCol = $request->sortCol ?? 'id';
        $sortType = $request->sortType ?? 'asc';
        $offset = isset($request->pageNum) && $request->pageNum ? ($request->pageNum - 1) * $itemsPerPage : 0;
        $limit = $itemsPerPage;






        global $arrival_province_code, $departure_province_code, $diff_days;

        /////Filter
        if (isset($request->arrival_province_code) && $request->arrival_province_code != 'null') {
            $arrival_province_code = $request->arrival_province_code;
            $query = $query->whereHas('schedule', function (Builder $queryTemp) {
                $queryTemp->where('arrival_province_code', $GLOBALS['arrival_province_code']);
            });
        }
        if (isset($request->departure_province_code) && $request->departure_province_code != 'null') {
            $departure_province_code = $request->departure_province_code;
            $query = $query->whereHas('schedule', function (Builder $queryTemp) {
                $queryTemp->where('departure_province_code', $GLOBALS['departure_province_code']);
            });
        }

        if (isset($request->coach_id) && $request->coach_id != 'null')  $query = $query->where('coach_id', $request->coach_id);
        if (isset($request->departure_date) && $request->departure_date != '') {
            $query = $query->where('departure_date', $request->departure_date);
            if (isset($request->arrival_date) && $request->arrival_date != '') {
                $diff_days =  (int)((strtotime($request->arrival_date) - strtotime($request->departure_date)) / 86400);
                $query = $query->whereHas('schedule', function (Builder $queryTemp) {
                    $queryTemp->where('arrival_time', '>=', $GLOBALS['diff_days'] * 1440)
                        ->where('arrival_time', '<', ($GLOBALS['diff_days'] + 1) * 1440);
                });
            }
        }

        // Cach filter arrival_date
        // 1 - Tao them cot arrival_date (chi dung de filter)  thi co the filter arrival date voi tat ca departure date (Them cot -> nang table->Loai)
        // 2 - Chi filter arrival  date voi 1 ngay departure date nhat dinh -> Chon



        ///////////// Xu ly caci arrival date diiiiiiiiii
        $totalPage = (!empty($request->isFilter) || !isset($request->isFilter)) ? ceil(($query->count()) / $itemsPerPage) : -1;




        //if only select one trip
        if ($trip_id !== null) $query = $query->where('id', $trip_id);


        //Retrieve
        $trips = $query->orderBy($sortCol, $sortType)->offset($offset)->limit($limit)->with(['coach:id,name,seat_number,photo', 'schedule.arrival_province', 'schedule.departure_province'])->get();


        $trips = $trips->map(function ($item) {
            $item->schedule->get_informations_without_detail();
            $item->arrival_date = date('Y-m-d', strtotime($item->departure_date . ' + ' . $item->schedule->total_days . ' days'));
            $coach =
                [
                    'name' => $item->coach->name,
                    'seat_number' => $item->coach->seat_number,
                    'photo' =>$item->coach->photo
                ];
            unset(
                $item->coach_id,
                $item->schedule->total_days,
                $item->service_provider_id,
                $item->coach,
                $item->schedule->id,
                $item->schedule->service_provider_id,

            );
            $item->coach = $coach;
            return $item;
        });




        return [
            'trips' => $trips->toArray(),
            'total_page' => $totalPage,
        ];
    }
}
