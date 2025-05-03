<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Channel for reservation status changes
Broadcast::channel('reservation.{id}', function ($user, $id) {
    // Only allow the reservation owner to listen to this channel
    return \App\Models\Reservation::where('id', $id)
        ->where('user_id', $user->id)
        ->exists();
});


Broadcast::channel('chat', function(){

});
