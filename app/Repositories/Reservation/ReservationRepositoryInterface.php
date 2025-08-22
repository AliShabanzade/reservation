<?php

namespace App\Repositories\Reservation;

use App\Repositories\BaseRepositoryInterface;
use App\Models\Reservation;

interface ReservationRepositoryInterface extends BaseRepositoryInterface
{
    public function getModel(): Reservation;
}
