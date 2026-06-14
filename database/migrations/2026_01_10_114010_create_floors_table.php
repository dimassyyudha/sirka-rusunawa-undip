<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('floors', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->foreignUlid('building_id')
                ->constrained('buildings')
                ->cascadeOnDelete();

            $table->integer('floor_number');
            $table->integer('total_rooms')->default(0);
            $table->integer('monthly_price')->default(0);
            $table->integer('room_capacity')->default(2);
            // $table->string('payment_period')->default('6 bulan');

            $table->timestamps();

            $table->unique(['building_id', 'floor_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('floors');
    }
};