<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\RoomResource;
use App\Models\Room;
use App\Repositories\Room\RoomRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends ApiBaseController
{
    public function index(RoomRepositoryInterface $rooms): JsonResponse
    {
        return $this->successResponse(
            RoomResource::collection($rooms->get()),
            "Rooms fetched successfully"
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }
}
