<?php

namespace App\Models;

use App\Enums\CoachTypesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;
    const UPDATED_AT = null;
    protected $fillable = [
        'name',
        'type',
        'seat_number',
        'service_provider_id',

    ];
    public function getTypeNameAttribute()
    {
        return strtolower(CoachTypesEnum::getKey($this->type));
    }
}
