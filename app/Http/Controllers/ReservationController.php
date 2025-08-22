<?php

namespace App\Http\Controllers;

use App\Domain\Reservations\Services\ReservationService;
use App\Models\Reservation;
use App\Repositories\Reservation\ReservationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function __construct(
        private ReservationService $service,
        private ReservationRepository $reservations
    ) {
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function store(Request $request): JsonResponse
    {
//        dd(111111);
        $data = $request->validate([
            'user_id'  => ['required', 'integer', 'exists:users,id'],
            'room_id'  => ['required', 'integer', 'exists:rooms,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $result = $this->service->reserve($data['user_id'], $data['room_id'], $data['quantity']);

        if (!$result->ok) {
            $code = match ($result->message) {
                'room_not_found' => 404,
                'insufficient_capacity' => 422,
                default => 400,
            };

            return response()->json([
                'error' => [
                    'code' => $result->message,
                    'message' => __($result->message),
                ],
            ], $code);
        }

        $reservation = $this->reservations->find($result->reservationId);

        return response()->json([
            'data' => [
                'id'         => $reservation->id,
                'user_id'    => $reservation->user_id,
                'room_id'    => $reservation->room_id,
                'quantity'   => $reservation->quantity,
                'status'     => $reservation->status,
                'expires_at' => $reservation->expires_at?->toIso8601String(),
            ],
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $res = $this->reservations->find($id);
        if (!$res) {
            return response()->json(['error' => ['code' => 'not_found', 'message' => 'reservation not found']], 404);
        }

        return response()->json(['data' => [
            'id'         => $res->id,
            'user_id'    => $res->user_id,
            'room_id'    => $res->room_id,
            'quantity'   => $res->quantity,
            'status'     => $res->status,
            'expires_at' => $res->expires_at?->toIso8601String(),
        ]]);
    }

    public function cancel(int $id): JsonResponse
    {
        $res = $this->service->cancel($id);
        if (!$res) {
            return response()->json(['error' => ['code' => 'not_cancellable', 'message' => 'reservation not active']], 422);
        }

        return response()->json(['data' => ['id' => $res->id, 'status' => $res->status]]);
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }


}
