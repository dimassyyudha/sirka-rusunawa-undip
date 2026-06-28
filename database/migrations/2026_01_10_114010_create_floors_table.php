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
        Schema::create('floors', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->char('floor_id', 10)->primary();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY
            |--------------------------------------------------------------------------
            */

            $table->char('building_id', 10);

            /*
            |--------------------------------------------------------------------------
            | FLOOR INFORMATION
            |--------------------------------------------------------------------------
            */

            $table->unsignedTinyInteger('floor_number');

            $table->unsignedInteger('total_rooms');

            $table->unsignedInteger('monthly_price');

            $table->unsignedTinyInteger('room_capacity');

            /*
            |--------------------------------------------------------------------------
            | TIMESTAMPS
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY CONSTRAINT
            |--------------------------------------------------------------------------
            */

            $table->foreign('building_id')
                ->references('building_id')
                ->on('buildings')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index('building_id');
            $table->index('floor_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('floors');
    }
};
