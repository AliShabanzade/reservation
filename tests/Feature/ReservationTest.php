<?php

namespace Tests\Feature;

use App\Domain\Reservations\Jobs\ExpireReservationJob;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Date;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_reserves_a_room_and_reduces_capacity_linked_to_a_user()
    {
        $user = User::factory()->create();
        $room = Room::factory()->create(['capacity_available' => 5]);

        $resp = $this->postJson('/api/reservations', [
            'user_id' => $user->id,
            'room_id' => $room->id,
            'quantity' => 3,
        ])->assertCreated();

        $resp->assertJsonPath('data.user_id', $user->id);

        $this->assertDatabaseHas('reservations', [
            'user_id'   => $user->id,
            'room_id'   => $room->id,
            'quantity'  => 3,
            'status'    => 'active',
        ]);

        $this->assertDatabaseHas('rooms', [
            'id'                   => $room->id,
            'capacity_available'   => 2,
        ]);
    }

    /** @test */
    public function it_prevents_oversell_when_requested_quantity_exceeds_capacity()
    {
        $user = User::factory()->create();
        $room = Room::factory()->create(['capacity_available' => 2]);

        $this->postJson('/api/reservations', [
            'user_id' => $user->id,
            'room_id' => $room->id,
            'quantity' => 3,
        ])
             ->assertStatus(422)
             ->assertJsonPath('error.code', 'insufficient_capacity');

        $this->assertDatabaseHas('rooms', [
            'id'                 => $room->id,
            'capacity_available' => 2,
        ]);
    }

    /** @test */
    public function it_dispatches_a_job_to_expire_reservation_after_ttl()
    {
        Bus::fake();

        $user = User::factory()->create();
        $room = Room::factory()->create(['capacity_available' => 5]);

        $response = $this->postJson('/api/reservations', [
            'user_id' => $user->id,
            'room_id' => $room->id,
            'quantity' => 2,
        ])->assertCreated();

        $reservationId = $response->json('data.id');

        Bus::assertDispatched(ExpireReservationJob::class, function ($job) use ($reservationId) {
            return $job->reservationId === $reservationId;
        });
    }

    /** @test */
    public function it_expires_reservation_after_ttl_and_restores_capacity()
    {
        Bus::fake();

        $user = User::factory()->create();
        $room = Room::factory()->create(['capacity_available' => 4]);

        $response = $this->postJson('/api/reservations', [
            'user_id' => $user->id,
            'room_id' => $room->id,
            'quantity' => 2,
        ])->assertCreated()->json('data');

        Bus::assertDispatched(ExpireReservationJob::class);

        Date::setTestNow(now()->addMinutes(3));

        $this->artisan('reservations:expire')->assertExitCode(0);

        $this->assertDatabaseHas('reservations', [
            'id'     => $response['id'],
            'status' => 'expired',
        ]);

        $this->assertDatabaseHas('rooms', [
            'id'                 => $room->id,
            'capacity_available' => 4,
        ]);
    }
}
