<?php

namespace App\Domain\Reservations\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Facades\Log;

class ReservationExpired
{
    use Dispatchable;

    public function __construct(public int $reservationId)
    {
        //  log to know when this event fires
        Log::info("🔥 Event fired: ReservationExpired for reservation #{$this->reservationId}");
    }
}
