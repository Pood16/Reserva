<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    /**
     * Get all of the restaurants that the user has favorited.
     */
    public function favoriteRestaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'favorites')->withTimestamps();
    }

    /**
     * Determine if the user has favorited the given restaurant.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return bool
     */
    public function hasFavorited(Restaurant $restaurant)
    {
        return $this->favoriteRestaurants()->where('restaurant_id', $restaurant->id)->exists();
    }
}
