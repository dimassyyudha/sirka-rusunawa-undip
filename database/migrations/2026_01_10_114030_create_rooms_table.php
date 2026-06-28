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
        Schema::create('rooms', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->char('room_id', 10)->primary();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY
            |--------------------------------------------------------------------------
            */

            $table->char('floor_id', 10);

            /*
            |--------------------------------------------------------------------------
            | ROOM INFORMATION
            |--------------------------------------------------------------------------
            */

            $table->string('kode_kamar', 5)->unique();

            $table->unsignedTinyInteger('occupied')->default(0);

            $table->text('fasilitas')->nullable();

            $table->enum('status', [
                'tersedia',
                'penuh',
                'maintenance',
            ])->default('tersedia');

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

            $table->foreign('floor_id')
                ->references('floor_id')
                ->on('floors')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index('floor_id');
            $table->index('status');
            $table->index('kode_kamar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
