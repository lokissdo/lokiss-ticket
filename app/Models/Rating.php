<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'trip_id',
        'service_provider_id',
        'comment',
        'rate',
        'user_id'
    ];
    const UPDATED_AT = null;
    public function getRatingAvgCacheKey($service_provider_id)
    {
        return sprintf('rating-avg-%d', $service_provider_id);
    }
    public function getRatingCountCacheKey($service_provider_id)
    {
        return sprintf('rating-count-%d', $service_provider_id);
    }
    static function get_general_ratings_by_service_provider_list($serviceProviderIdLists)
    {
        $result = [];
        foreach ($serviceProviderIdLists as $key => $each) {
            $avgRatings = Cache::get(self::getRatingAvgCacheKey($each));
            $countRatings = Cache::get(self::getRatingCountCacheKey($each));

            if ($avgRatings !== null && $countRatings !== null) {

                $result[$each] = [
                    'count' => (int)$countRatings,
                    'rate' => (float)$avgRatings
                ];
                unset($serviceProviderIdLists[$key]);
            };
        }
        if(count($serviceProviderIdLists)===0) return $result;
        $extraRating = self::whereIn('service_provider_id', $serviceProviderIdLists)
            ->groupBy('service_provider_id')
            ->select([DB::raw('COUNT(service_provider_id) as count '), DB::raw('AVG(rate) as rate'), 'service_provider_id'])
            ->get();
        foreach ($extraRating as  $each) {
            $SPId = $each->service_provider_id;
            $result[$SPId] = [
                'count' => $each->count,
                'rate' => $each->rate
            ];
            Cache::put(self::getRatingAvgCacheKey($SPId),  $each->rate, 24 * 60 * 60);
            Cache::put(self::getRatingCountCacheKey($SPId),  $each->count, 24 * 60 * 60);
        }
        return $result;
    }
}
