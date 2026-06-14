<?php

// ======================================================
// FINAL invoices TABLE
// ======================================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {

            $table->ulid('id')->primary();

            $table->foreignUlid('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignUlid('reservation_id')
                ->constrained('reservations')
                ->cascadeOnDelete();

            $table->foreignUlid('room_id')
                ->nullable()
                ->constrained('rooms')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | INVOICE
            |--------------------------------------------------------------------------
            */

            $table->string('invoice_number')
                ->unique();

            $table->enum('invoice_type', [
                'new',
                'extension',
                'transfer',
                'checkout',
                'penalty',
            ])->default('new');

            $table->unsignedInteger('amount')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'unpaid',
                'paid',
                'expired',
                'cancelled',
                'failed',
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | DATE
            |--------------------------------------------------------------------------
            */

            $table->timestamp('due_at')
                ->nullable();

            $table->timestamp('paid_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | DESCRIPTION
            |--------------------------------------------------------------------------
            */

            $table->text('description')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index(['user_id']);
            $table->index(['reservation_id']);
            $table->index(['invoice_number']);
            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
