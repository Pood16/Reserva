<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    public function RestaurantFoodTypes()
    {
        return $this->hasMany(RestaurantFoodType::class);
    }
    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'restaurant_food_types');
    }


}
