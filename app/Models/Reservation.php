<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Reservation extends Model
{

    protected $table = 'bookings';
    protected $fillable = [
        'table_id',
        'user_id',
        'restaurant_id',
        'booking_date',
        'end_time',
        'guests_number',
        'special_requests',
        'status',
        'decline_reason',
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'end_time' => 'datetime',
        'guests_number' => 'integer',
    ];


    public function table()
    {
        return $this->belongsTo(Table::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

}
