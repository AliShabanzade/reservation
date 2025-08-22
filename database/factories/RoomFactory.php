<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'capacity_available' => fake()->numberBetween(1, 5),
            'name' => fake()->unique()->randomElement([
                'Standard Twin',
                'Deluxe King',
                'Family Suite',
                'Penthouse',
                'President'
            ]),
        ];
    }
}
