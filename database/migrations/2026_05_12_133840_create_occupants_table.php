<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('occupants', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->char('occupant_id', 10)->primary();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY
            |--------------------------------------------------------------------------
            */

            $table->char('user_id', 10);

            $table->char('room_id', 10);

            $table->char('reservation_id', 10);

            /*
            |--------------------------------------------------------------------------
            | OCCUPANCY
            |--------------------------------------------------------------------------
            */

            $table->date('start_date');

            $table->date('end_date')->nullable();

            $table->enum('status', [
                'active',
                'moved',
                'checked_out',
                'completed',
            ]);

            /*
            |--------------------------------------------------------------------------
            | TIMESTAMPS
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY
            |--------------------------------------------------------------------------
            */

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('room_id')
                ->references('room_id')
                ->on('rooms')
                ->cascadeOnDelete();

            $table->foreign('reservation_id')
                ->references('reservation_id')
                ->on('reservations')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index('user_id');
            $table->index('room_id');
            $table->index('reservation_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupants');
    }
};
