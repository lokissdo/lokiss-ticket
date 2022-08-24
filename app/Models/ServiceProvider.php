<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Enums\UserRoleEnum;

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
                    'label' => "Doanh thu tuần này",

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
                    'data' =>$count_trips,
                    'label' => "Chuyến đi tuần này",

                    // This binds the dataset to the right y axis
                ],
            ])
            ->optionsRaw("{
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
                grid: { display: false }
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
        return $revenues;
    }
}
