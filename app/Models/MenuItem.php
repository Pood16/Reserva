<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_id', 'name', 'description', 'price', 'image', 'is_available'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function foodType()
    {
        return $this->belongsTo(FoodType::class);
    }
}

