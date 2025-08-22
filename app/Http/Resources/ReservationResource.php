<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'room_id'    => $this->room_id,
            'quantity'   => $this->quantity,
            'status'     => $this->status,
            'expires_at' => $this->expires_at?->toIso8601String(),
        ];
    }
}
