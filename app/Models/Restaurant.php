<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'city',
        'phone',
        'email',
        'website',
        'opening_time',
        'closing_time',
        'user_id',
        'cover_image',
        'is_active',
        'max_booking_days_ahead',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'opening_time' => 'datetime',
        'closing_time' => 'datetime',
        'max_booking_days_ahead' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Reservation::class);
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(RestaurantImage::class);
    }


    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function openingDays()
    {
        return $this->hasMany(OpeningDay::class);
    }

    public function foodTypes()
    {
        return $this->belongsToMany(FoodType::class, 'restaurant_food_types');
    }
}


