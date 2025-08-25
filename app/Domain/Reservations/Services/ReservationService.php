<?php

namespace App\Domain\Reservations\Services;

use App\Domain\Reservations\DTO\ReservationResult;
use App\Domain\Reservations\Jobs\ExpireReservationJob;
use App\Models\Reservation;
use App\Repositories\Reservation\ReservationRepositoryInterface;
use App\Repositories\Room\RoomRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    public function __construct(
        private RoomRepositoryInterface $rooms,
        private ReservationRepositoryInterface $reservations,
        private int $ttlSeconds = 120, // 2 minutes
    ) {
    }

    public function reserve(int $userId, int $roomId, int $quantity): ReservationResult
    {
        if ($quantity <= 0) {
            return new ReservationResult(false, null, 'quantity_must_be_positive');
        }

        return DB::transaction(function () use ($userId, $roomId, $quantity) {


            $room = $this->rooms->findForUpdate($roomId);
            if (!$room) {
                return new ReservationResult(false, null, 'room_not_found');
            }

            if ($room->capacity_available < $quantity) {
                return new ReservationResult(false, null, 'insufficient_capacity');
            }

            $room->capacity_available -= $quantity;
            $this->rooms->save($room);

            $reservation = $this->reservations->
            store([
                'user_id'    => $userId,
                'room_id'    => $room->id,
                'quantity'   => $quantity,
                'status'     => 'active',
                'expires_at' => now()->addSeconds($this->ttlSeconds),
            ]);

            ExpireReservationJob::dispatch($reservation->id)->delay($reservation->expires_at);

            return new ReservationResult(true, $reservation->id, null);
        }, 5);
    }

    public function cancel(int $reservationId): ?Reservation
    {
        return DB::transaction(function () use ($reservationId) {


            $res = $this->reservations->findForUpdate($reservationId);
            if (!$res || $res->status !== 'active') {
                return null;
            }

            $room = $res->room()->lockForUpdate()->first();
            if ($room) {
                $room->capacity_available += $res->quantity;
                $room->save();
            }

            $res->status = 'cancelled';
            $res->save();

            return $res;
        }, 5);
    }
}
