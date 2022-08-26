<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Collection;

class ServiceProvider extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'phone_number',
        'address',
        'employer_id',
    ];
    const UPDATED_AT = null;

    public function employer()
    {
        return $this->hasOne(User::class, 'id', 'employer_id');
    }
    public function province()
    {
        return $this->belongsTo(Province::class, 'address', 'code');
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // public function bookmarks(): HasMany
    // {
    //     return $this->hasMany(Bookmark::class);
    // }

    // protected function getBookmarksCacheKey(): string
    // {
    //     return sprintf('user-%d-bookmarks', $this->id);
    // }

    // public function clearBookmarksCache(): bool
    // {
    //     return Cache::forget($this->getBookmarksCacheKey());
    // }

    // public function getBookmarksAttribute(): Collection
    // {
    //     if ($this->relationLoaded('bookmarks')) {
    //         return $this->getRelationValue('bookmarks');
    //     }

    //     $bookmarks = Cache::rememberForever($this->getBookmarksCacheKey(), function () {
    //         return $this->getRelationValue('bookmarks');
    //     });

    //     $this->setRelation('bookmarks', $bookmarks);

    //     return $bookmarks;
    // }



    public function getAddressNameAttribute()
    {
        return $this->province->name;
    }
    public function getRateInforAttribute()
    {
        return $this->rate_avg . ' (' . $this->rate_count . ')';
    }
    public function getRateAvgAttribute()
    {
        $count = $this->rate_count;
        if ($count === 0) return 0;
        $total = $this->ratings->reduce(function ($pre, $item) {
            return $pre + $item->rate;
        }, 0);
        return round($total / $count, 2);
    }
    public function getRateCountAttribute()
    {
        return $this->ratings->count();
    }
    public function getEmailAttribute()
    {
        return  $this->employer->email;
    }
    public function employees()
    {
        return $this->hasMany(EmployeesList::class, 'service_provider_id', 'id');
    }
    static function weekly_revenue_line($service_provider_id)
    {

        $data = self::get_revenue_data_7daysbefore($service_provider_id);
        $labels = array_column($data, 'date');
        $revenues = array_column($data, 'revenue');
        $count_trips = array_column($data, 'count');
        $chartjs = app()->chartjs
            ->name('barChartTest')
            // ->type(['bar'])
            ->size(['width' => 400, 'height' => 200])
            ->labels($labels)
            ->datasets([
                [
                    'type' => 'line',
                    'yAxisID' => "leftaxis",
                    'data' => $revenues,
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'label' => "Doanh thu",

                    // This binds the dataset to the left y axis
                ], [
                    'type' => 'bar',
                    'yAxisID' => "rightaxis",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $count_trips,
                    'label' => "Số chuyến đi ",

                    // This binds the dataset to the right y axis
                ],
            ])
            ->optionsRaw("{
                plugins:{
                    title: {
                        display: true,
                        text: 'Thống kê 7 ngày gần nhất',
                        font: {
                            size: 20
                        }
                    }
                },
            scales: {
                rightaxis: {
                type: 'linear',
                position: 'right',
                ticks: { beginAtZero: true, color: 'blue',precision: 0 },
                grid: { display: false }
              },
              leftaxis: {
                type: 'linear',
                position:'left',
                ticks: { beginAtZero: true, color: 'blue' },
              },
            }, 
          }");
        return $chartjs;
    }
    private function get_revenue_data_7daysbefore($service_provider_id)
    {
        $revenues = [];
        for ($i = 0; $i < 7; ++$i) {
            $revenues[$i]['date'] = date("d-m-Y", strtotime("- " . "$i" . " days"));
            $revenues[$i]['revenue'] = 0;
            $trips = Trip::where('service_provider_id', $service_provider_id)->where('departure_date', date("Y-m-d", strtotime("- " . "$i" . " days")))
                ->withCount('tickets')->get();
            $revenues[$i]['count'] = count($trips);
            foreach ($trips as $each) {
                $revenues[$i]['revenue'] += $each->price * $each->tickets_count;
            }
        }
        return array_reverse($revenues);
    }
    public static  function daily_analyst_line($service_provider_id)
    {

        $data = self::get_daily_data($service_provider_id);
        $chartDay = app()->chartjs
            ->name('pieChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($data['labels'])
            ->datasets([[
                'label' => 'Doanh thu',
                'yAxisID' => "leftaxis",
                'data' => $data['revenue'],
                'backgroundColor' => "rgba(0,0,255,1)"
            ], [
                'label' => 'Tỉ lệ lấp đầy',
                'yAxisID' => "rightaxis",
                'detail'=>$data['occupied_rate'],
                'data' => array_column($data['occupied_rate'], 'rate'),
                'backgroundColor' => "rgba(255,0,0,1)"
            ]])
            ->optionsRaw("{
                plugins:{
                    title: {
                        display: true,
                        text: 'Các chuyến hôm nay',
                        font: {
                            size: 20
                        }
                    },
                tooltip: {
                    
                    callbacks: {
                       afterBody: function(context) {
                        if(context[0].datasetIndex===1){
                            let detail=context[0].dataset.detail[context[0].dataIndex]
                          return detail.occupied+'/'+detail.total;  // return a string that you wish to append
                       }
                       return;
                    },
                    label: function(context) {
                        if(context.datasetIndex===1){
                        console.log(context)
                        return context.dataset.label+': '+ Math.round(Number(context.formattedValue)  * 100) + '%';
                        }
                        return context.dataset.label+': ' +context.formattedValue+'VNĐ';
                    }
                    }
                 }
                },
                scales: {
                    rightaxis: {
                    type: 'linear',
                    position: 'right',
                    max:1,
                    ticks: { 
                        beginAtZero: true, color: 'blue',
                        callback: function(value, index, values) {
                            return Math.round(value  * 100) + '%';
                        } 
                    },
                   
                grid: { display: false }

                  },
                  leftaxis: {
                    type: 'linear',
                    position:'left',
                    ticks: { 
                        beginAtZero: true, color: 'blue' },
                grid: { display: false }

                  },
                  
                }, 
              }");
        return $chartDay;
    }
    private static function get_daily_data($service_provider_id)
    {
        $trips = Trip::where('service_provider_id', $service_provider_id)->where('departure_date', date('Y-m-d'))
            ->withCount('tickets')->with(['schedule.departure_province', 'schedule.arrival_province', 'coach'])->get();
        $labels = [];
        $occupiedRate = [];
        $revenue = [];
        foreach ($trips as $each) {
            $schedule = $each->schedule;
            $labels[] = $schedule->departure_province->short_name . ' ⇒ ' . $schedule->arrival_province->short_name . ' ' . date('H:i', strtotime($schedule->departure_time));
            $occupiedRate[] = [
                'rate' => $each['tickets_count'] / $each->coach->seat_number,
                'occupied' => $each['tickets_count'],
                'total' => $each->coach->seat_number
            ];
            $revenue[] = $each->price * $each['tickets_count'];
        }
        return [
            'labels' => $labels,
            'revenue' => $revenue,
            'occupied_rate' => $occupiedRate
        ];
    }
    public static function total_revenue_this_week($service_provider_id){
       $trips= Trip::where('service_provider_id',$service_provider_id)->whereBetween('departure_date', [date('Y-m-d',strtotime(now()->startOfWeek())), date('Y-m-d',strtotime(now()->endOfWeek()))])->withCount('tickets')->get();
      return self::get_total_revenue_from_trips($trips);
    }
    private static function get_total_revenue_from_trips($trips){
        $total=0;
        foreach ($trips as $trip) {
         $total+=$trip->price*$trip->tickets_count;
        }
       return $total;
    }
    public static function total_revenue_this_month($service_provider_id){
        $trips= Trip::where('service_provider_id',$service_provider_id)->whereBetween('departure_date', [date('Y-m-d',strtotime(now()->startOfmonth())), date('Y-m-d',strtotime(now()->endOfMonth()))])->withCount('tickets')->get();
      return self::get_total_revenue_from_trips($trips);
     }
     public static function total_revenue_today($service_provider_id){
        $trips= Trip::where('service_provider_id',$service_provider_id)->where('departure_date', date('Y-m-d'))->withCount('tickets')->get();
      return self::get_total_revenue_from_trips($trips);
     }
    public static function revenue_numbers($service_provider_id){
        $week=self::total_revenue_this_week($service_provider_id);
        $month=self::total_revenue_this_month($service_provider_id);
        $day=self::total_revenue_today($service_provider_id);
        return [
            'month'=>$month,
            'week'=>$week,
            'day'=>$day
        ];
    }
}
