<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_photos', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->char('photo_id', 10)->primary();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY
            |--------------------------------------------------------------------------
            */

            $table->char('room_id', 10);

            /*
            |--------------------------------------------------------------------------
            | PHOTO
            |--------------------------------------------------------------------------
            */

            $table->string('photo_path');

            $table->boolean('is_primary')->default(false);

            $table->unsignedInteger('sort_order')->default(1);

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY
            |--------------------------------------------------------------------------
            */

            $table->foreign('room_id')
                ->references('room_id')
                ->on('rooms')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_photos');
    }
};
