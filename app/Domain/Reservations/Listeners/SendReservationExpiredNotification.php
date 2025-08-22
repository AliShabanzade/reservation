<?php

namespace App\Domain\Reservations\Listeners;

use App\Domain\Reservations\Events\ReservationExpired;
use Illuminate\Support\Facades\Log;

class SendReservationExpiredNotification
{
    public function handle(ReservationExpired $event): void
    {
        Log::info(" Listener triggered: Sending email for reservation #{$event->reservationId}");
    }
}
