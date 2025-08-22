<?php

namespace App\Providers;

use App\Repositories\Reservation\ReservationRepository;
use App\Repositories\Reservation\ReservationRepositoryInterface;
use App\Repositories\Room\RoomRepository;
use App\Repositories\Room\RoomRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
           $this->app->bind(RoomRepositoryInterface::class , RoomRepository::class);
           $this->app->bind(ReservationRepositoryInterface::class , ReservationRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
