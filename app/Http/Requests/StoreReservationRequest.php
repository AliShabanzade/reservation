<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // add auth logic if needed
    }

    public function rules(): array
    {
        return [
            'user_id'  => ['required', 'integer', 'exists:users,id'],
            'room_id'  => ['required', 'integer', 'exists:rooms,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
