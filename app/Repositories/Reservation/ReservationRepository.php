<?php

namespace App\Repositories\Reservation;

use App\Models\Reservation;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

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
}
