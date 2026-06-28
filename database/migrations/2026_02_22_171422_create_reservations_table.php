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
        Schema::create('reservations', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->char('reservation_id', 10)->primary();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY
            |--------------------------------------------------------------------------
            */

            $table->char('room_id', 10);

            $table->char('user_id', 10);

            $table->char('occupancy_period_id', 10)->nullable();

            /*
            |--------------------------------------------------------------------------
            | RESERVATION
            |--------------------------------------------------------------------------
            */

            $table->string('reservation_code', 8)->unique();

            $table->string('contact_name');

            $table->string('contact_phone', 20);

            $table->string('contact_email');

            /*
            |--------------------------------------------------------------------------
            | STUDENT
            |--------------------------------------------------------------------------
            */

            $table->string('guest_name');

            $table->string('guest_nim', 14);

            $table->string('guest_faculty', 100);

            $table->string('guest_major', 100);

            $table->year('guest_intake_year');

            /*
            |--------------------------------------------------------------------------
            | PARENT
            |--------------------------------------------------------------------------
            */

            $table->string('parent_name');

            $table->string('parent_phone', 20);

            /*
            |--------------------------------------------------------------------------
            | LEASE
            |--------------------------------------------------------------------------
            */

            $table->date('start_date');

            $table->date('end_date');

            $table->unsignedTinyInteger('duration_month');

            $table->unsignedTinyInteger('payment_term');

            $table->enum('occupancy_type', [
                'private',
                'shared',
            ]);

            $table->unsignedTinyInteger('slot_used');

            $table->unsignedInteger('price_per_month');

            $table->unsignedBigInteger('total_price');

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

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

            /*
            |--------------------------------------------------------------------------
            | OTHER
            |--------------------------------------------------------------------------
            */

            $table->text('special_request')->nullable();

            $table->enum('reservation_type', [
                'new',
                'extension',
                'transfer',
                'checkout',
            ]);

            $table->char('previous_room_id', 10)
                ->default('0');

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

            $table->foreign('room_id')
                ->references('room_id')
                ->on('rooms')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('occupancy_period_id')
                ->references('occupancy_period_id')
                ->on('occupancy_periods')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index('reservation_code');
            $table->index('status');
            $table->index('reservation_type');
            $table->index('room_id');
            $table->index('user_id');
            $table->index('occupancy_period_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
