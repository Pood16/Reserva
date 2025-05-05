<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ManagerRequest extends Model
{
    use Notifiable;

    protected $fillable = [
        'FirstName',
        'LastName',
        'Email',
        'status'
    ];

    

}
