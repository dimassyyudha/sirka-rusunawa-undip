<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('reservation_code', 8)->unique();

            $table->foreignUlid('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignUlid('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('contact_name');
            $table->string('contact_phone', 20);
            $table->string('contact_email');

            $table->string('guest_name');
            $table->string('guest_nim', 14);
            $table->string('guest_faculty', 100);
            $table->string('guest_major', 100);
            $table->year('guest_intake_year');

            $table->string('parent_name');
            $table->string('parent_phone', 20);

            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedTinyInteger('duration_month')->default(6);
            $table->unsignedTinyInteger('payment_term')->default(1);
            $table->enum('occupancy_type', ['private', 'shared']);
            $table->unsignedTinyInteger('slot_used')->default(1);

            $table->unsignedInteger('price_per_month')->default(0);
            $table->unsignedInteger('total_price')->default(0);

            $table->enum('status', [
                'pending',
                'paid',
                'approved',
                'active',
                'rejected',
                'cancelled',
                'expired',
                'completed',
                'checked_out',
            ])->default('pending');

            $table->text('special_request')->nullable();
            $table->timestamps();

            $table->index(['room_id', 'status']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
