<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();

            $table->unsignedInteger('quantity');
            $table->enum('status', ['active', 'expired', 'cancelled'])->index();
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamps();

            // Composite index that’s useful for querying active reservations of a user
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
