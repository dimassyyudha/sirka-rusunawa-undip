<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->foreignUlid('floor_id')
                ->constrained('floors')
                ->cascadeOnDelete();

            $table->string('kode_kamar', 5)->unique();

            $table->unsignedTinyInteger('occupied')->default(0);

            $table->text('fasilitas');

            $table->enum('status', [
                'tersedia',
                'penuh',
                'maintenance',
            ])->default('tersedia');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
