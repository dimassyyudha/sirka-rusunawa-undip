<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_reviews', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->foreignUlid('room_id')
                ->constrained('rooms')
                ->cascadeOnDelete();

            $table->foreignUlid('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->tinyInteger('rating'); // 1 - 5
            $table->text('comment')->nullable();
            $table->boolean('is_visible')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_reviews');
    }
};