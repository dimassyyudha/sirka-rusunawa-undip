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
        Schema::table('reservations', function (Blueprint $table) {

            $table->foreignUlid('occupancy_period_id')
                ->nullable()
                ->after('user_id')
                ->constrained('occupancy_periods')
                ->nullOnDelete();

            $table->enum('reservation_type', [
                'new',
                'extension',
                'transfer',
                'checkout',
            ])->default('new');

            $table->foreignUlid('previous_room_id')
                ->nullable()
                ->constrained('rooms')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            //
        });
    }
};
