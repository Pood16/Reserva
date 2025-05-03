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

    public function getFullNameAttribute()
    {
        return $this->FirstName . ' ' . $this->LastName;
    }
    
    /**
     * Route notifications for the mail channel.
     */
    public function routeNotificationForMail(): string
    {
        return $this->Email;
    }
}
