<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagerRequest extends Model
{
    protected $fillable = [
        'FirstName',
        'LastName',
        'Email',
    ];

    public function getFullNameAttribute()
    {
        return $this->FirstName . ' ' . $this->LastName;
    }
}
