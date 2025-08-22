<?php

namespace App\Repositories\Room;

use App\Models\Room;
use App\Repositories\BaseRepositoryInterface;


interface RoomRepositoryInterface extends BaseRepositoryInterface
{
    public function getModel(): Room;

    public function findForUpdate(int $id): ?Room;
}
