<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Wajib pilih kamar & tidak boleh dobel
            $table->ulid('room_id')->unique();
            $table->unsignedInteger('sort_order')->unique(); // wajib unik & > 0

            $table->string('badge')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // FK: kalau kamar dihapus, rekomendasi ikut terhapus (lebih aman daripada SET NULL)
            $table->foreign('room_id')
                ->references('id')->on('rooms')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};
