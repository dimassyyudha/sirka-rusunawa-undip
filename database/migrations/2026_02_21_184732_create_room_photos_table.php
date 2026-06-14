<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_photos', function (Blueprint $table) {
            $table->ulid('id');

            // rooms.id kamu ULID, jadi pakai foreignUlid
            $table->foreignUlid('room_id')
                ->constrained('rooms')
                ->cascadeOnDelete();

            // path relatif file, misal: uploads/rooms/{room_id}/nama-file.jpg
            $table->string('path');

            // opsional: penanda foto utama & urutan tampilan
            $table->boolean('is_primary')->default(false);
            $table->unsignedInteger('order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_photos');
    }
};