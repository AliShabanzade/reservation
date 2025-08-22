<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Room;
use App\Repositories\Room\RoomRepository;
use App\Http\Resources\RoomResource;
use App\Http\Controllers\Api\v1\ApiBaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends ApiBaseController
{
    public function index(RoomRepository $rooms): JsonResponse
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
