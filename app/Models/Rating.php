<?php

namespace App\Models;

use App\Constants\ItemsPerPage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Thiagoprz\CompositeKey\HasCompositeKey;
class Rating extends Model
{
    use HasFactory;
    use HasCompositeKey;
    protected $fillable = [
        'trip_id',
        'service_provider_id',
        'comment',
        'rate',
        'user_id'
    ];
    const UPDATED_AT = null;
    protected $primaryKey = ['user_id', 'trip_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
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
    public static function get_comments_by_service_provider($service_provider_id,$offset=0,$take=ItemsPerPage::COMMENTS){
        return self::where('service_provider_id',$service_provider_id)->with('user:id,name,avatar')->offset($offset)->take($take)->get();
    }
    public static function get_comments_by_user_and_trip(int $trip_id,int $user_id ){
        return self::where('trip_id',$trip_id)->where('user_id',$user_id)->first();
    }
}
