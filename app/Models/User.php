<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
    ];


    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }


    public function favoriteRestaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'favorites')->withTimestamps();
    }


    public function hasFavorited(Restaurant $restaurant)
    {
        return $this->favoriteRestaurants()->where('restaurant_id', $restaurant->id)->exists();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
