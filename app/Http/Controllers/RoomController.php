<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Repositories\Room\RoomRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RoomRepository $rooms): JsonResponse
    {
        return response()->json([
            'data' => $rooms->get(),
        ]);
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
