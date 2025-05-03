<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantFoodType extends Model
{
    protected $fillable = [
        'restaurant_id',
        'food_type_id',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function foodType()
    {
        return $this->belongsTo(FoodType::class);
    }
}
