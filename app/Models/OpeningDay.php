<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpeningDay extends Model
{
    protected $fillable = [
        'restaurant_id',
        'day_of_week',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
