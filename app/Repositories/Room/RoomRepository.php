<?php

namespace App\Repositories\Room;

use App\Models\Room;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{
    public function __construct(Room $model)
    {
        parent::__construct($model);
    }

   public function getModel(): Room
   {
       return parent::getModel();
   }


    public function findForUpdate(int $id): ?Room
    {
        return Room::whereKey($id)->lockForUpdate()->first();
    }

    public function get(array $payload = []): Collection|array
    {
        return Room::query()->orderBy('id')->get(['id', 'name', 'capacity_available']);
    }


}
