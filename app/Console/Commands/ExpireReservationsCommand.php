<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpireReservationsCommand extends Command
{
    protected $signature = 'reservations:expire';
    protected $description = 'Expire active reservations past their expiry time';

    public function handle(): int
    {
        $count = 0;

        DB::transaction(function () use (&$count) {
            // پیدا کردن تعدادی رزرو منقضی شده و قفل آنها
            $expired = Reservation::where('status', 'active')
                                  ->where('expires_at', '<=', now())
                                  ->limit(200)
                                  ->lockForUpdate()
                                  ->get();

            foreach ($expired as $res) {
                $room = $res->room()->lockForUpdate()->first();
                if ($room) {
                    $room->capacity_available += $res->quantity;
                    $room->save();
                }

                $res->status = 'expired';
                $res->save();

                $count++;
            }
        });

        $this->info("Expired: {$count}");
        return self::SUCCESS;
    }
}
