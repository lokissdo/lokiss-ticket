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
        return $this->rate_avg . ' (' . $this->rate_count.')';
    }
    public function getRateAvgAttribute()
    {
        $count=$this->rate_count;
        if($count===0) return 0;
        $total = $this->ratings->reduce(function ($pre, $item) {
            return $pre + $item->rate;
        },0);
        return round($total/$count,2);
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
   
   
    
}
