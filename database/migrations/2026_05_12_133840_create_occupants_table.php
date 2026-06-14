<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('occupants', function (Blueprint $table) {

            $table->ulid('id')->primary();

            /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

            $table->foreignUlid('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignUlid('room_id')
                ->nullable()
                ->constrained('rooms')
                ->nullOnDelete();

            $table->foreignUlid('reservation_id')
                ->constrained('reservations')
                ->cascadeOnDelete();

            /*
    |--------------------------------------------------------------------------
    | OCCUPANCY
    |--------------------------------------------------------------------------
    */

            $table->date('start_date');

            $table->date('end_date');

            /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

            $table->enum('status', [
                'active',
                'moved',
                'checked_out',
                'completed',
            ])->default('active');

            $table->timestamps();

            /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

            $table->index(['user_id']);
            $table->index(['room_id']);
            $table->index(['reservation_id']);
            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('occupants');
    }
};
