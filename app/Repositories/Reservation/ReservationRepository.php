<?php

namespace App\Repositories\Reservation;

use App\Models\Reservation;
use App\Repositories\BaseRepository;

class ReservationRepository extends BaseRepository implements ReservationRepositoryInterface
{
    public function __construct(Reservation $model)
    {
        parent::__construct($model);
    }

   public function getModel(): Reservation
   {
       return parent::getModel();
   }


    public function findForUpdate(int $id): ?Reservation
    {
        return Reservation::whereKey($id)->lockForUpdate()->first();
    }
}
