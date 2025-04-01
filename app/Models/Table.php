<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'capacity',
        'is_available',
        'description',
        'location',
        'restaurant_id',
        'is_active'
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'is_active' => 'boolean',
        'capacity' => 'integer'
    ];


    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }


    public function bookings()
    {
        return $this->hasMany(Restaurant::class);
    }


    public function availableTables($query)
    {
        return $query->where('is_available', true);
    }


    public function activeTables($query)
    {
        return $query->where('is_active', true);
    }


    public function whereLocationIs($query, $location)
    {
        return $query->where('location', $location);
    }


    public function whereCapacityIs($query, $capacity)
    {
        return $query->where('capacity', '>=', $capacity);
    }
}
