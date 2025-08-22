<?php

namespace App\Domain\Reservations\DTO;

final class ReservationResult
{
    public function __construct(
        public bool $ok,
        public ?int $reservationId = null,
        public ?string $message = null
    ) {
    }
}
