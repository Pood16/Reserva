<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function getMinRating($query, $rating)
    {
        return $query->where('rating', '>=', $rating);
    }

    public function getNewest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }


    public function getHighestRated($query)
    {
        return $query->orderBy('rating', 'desc');
    }
}
