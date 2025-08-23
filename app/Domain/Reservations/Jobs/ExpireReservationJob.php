<?php

namespace App\Domain\Reservations\Jobs;

use App\Domain\Reservations\Events\ReservationExpired;
use App\Models\Reservation;
use App\Repositories\Reservation\ReservationRepository;
use App\Repositories\Reservation\ReservationRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ExpireReservationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $reservationId )
    {
    }

    public function handle(ReservationRepositoryInterface $reservationRepository): void
    {
        // مقدار را بیرون می‌کشیم تا در closure در دسترس باشد
        $reservationId = $this->reservationId;


        DB::transaction(function () use ($reservationId , $reservationRepository) {
            // قفل ردیف رزرو
            $res = $reservationRepository->findForUpdate($reservationId);

            if (!$res) {
                return;
            }

            // اگر هنوز فعال است و زمان انقضا گذشته است، آزادسازی را انجام بده
            if ($res->status !== 'active' || now()->lt($res->expires_at)) {
                return;
            }

            // قفل ردیف room و بازگردانی ظرفیت
            $room = $res->room()->lockForUpdate()->first();
            if ($room) {
                $room->capacity_available += $res->quantity;
                $room->save();
            }

            $res->status = 'expired';
            $res->save();

            event(new ReservationExpired($res->id));
        });
    }
}
