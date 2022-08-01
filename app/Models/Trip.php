<?php

namespace App\Models;

use App\Constants\ItemsPerPage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    static function get_trips($service_provider_id, $trip_id = null,$request=null)
    {
        $query = Trip::where('service_provider_id', $service_provider_id);


        // Get API
        $itemsPerPage = ItemsPerPage::USER;
        $sortCol = $request->sortCol ?? 'id';
        $sortType = $request->sortType ?? 'asc';
        $searchCol = $request->searchCol ?? 'name';
        $searchVal = $request->searchVal ?? '';
        $offset = isset($request->pageNum) && $request->pageNum ? ($request->pageNum - 1) * $itemsPerPage : 0;
        $limit = $itemsPerPage;

/////

        if ($trip_id !== null) $query = $query->where('id', $trip_id);
        $trips = $query->with(['coach:id,name,seat_number', 'schedule.arrival_province', 'schedule.departure_province'])->get();
        $trips = $trips->map(function ($item, $key) {
            $item->schedule->get_informations_without_detail();
            $item->arrival_date = date('Y-m-d', strtotime($item->departure_date . ' + ' . $item->schedule->total_days . ' days'));
            $coach =
                [
                    'name' => $item->coach->name,
                    'seat_number' => $item->coach->seat_number
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
        return $trips->toArray();
    }
}
