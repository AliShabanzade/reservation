<?php

namespace App\Http\Controllers\Api\v1;

use App\Domain\Reservations\Services\ReservationService;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Repositories\Reservation\ReservationRepositoryInterface;
use Illuminate\Http\JsonResponse;

class ReservationController extends ApiBaseController
{
    public function __construct(
        private ReservationService $service,
        private ReservationRepositoryInterface $reservations
    ) {}

    public function store(StoreReservationRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = $this->service->reserve($data['user_id'], $data['room_id'], $data['quantity']);

        if (!$result->ok) {
            $code = match ($result->message) {
                'room_not_found'        => 404,
                'insufficient_capacity' => 422,
                default                 => 400,
            };

            return $this->errorResponse(__($result->message), $code);
        }

        $reservation = $this->reservations->find($result->reservationId);

        return $this->successResponse(
            new ReservationResource($reservation),
            "Reservation created successfully",
            201
        );
    }

    public function show(int $id): JsonResponse
    {
        $res = $this->reservations->find($id);

        if (!$res) {
            return $this->errorResponse("Reservation not found", 404);
        }

        return $this->successResponse(ReservationResource::make($res));
    }

    public function cancel(int $id): JsonResponse
    {
        $res = $this->service->cancel($id);

        if (!$res) {
            return $this->errorResponse("Reservation not active", 422);
        }

        return $this->successResponse(ReservationResource::make($res), "Reservation cancelled");
    }
}
