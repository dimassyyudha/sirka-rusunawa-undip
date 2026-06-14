<?php

// ======================================================
// FINAL payment_transactions TABLE
// ======================================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {

            $table->ulid('id')->primary();

            $table->foreignUlid('invoice_id')
                ->constrained('invoices')
                ->cascadeOnDelete();

            $table->foreignUlid('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | MIDTRANS
            |--------------------------------------------------------------------------
            */

            $table->string('order_id')
                ->unique();

            $table->string('order_hash')
                ->unique();

            $table->string('payment_gateway')
                ->default('midtrans');

            /*
            |--------------------------------------------------------------------------
            | PAYMENT
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('gross_amount')
                ->default(0);

            $table->string('payment_type')
                ->nullable();

            $table->string('transaction_status')
                ->default('pending');

            $table->longText('snap_token')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | DATE
            |--------------------------------------------------------------------------
            */

            $table->timestamp('expired_at')
                ->nullable();

            $table->timestamp('paid_at')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index(['invoice_id']);
            $table->index(['user_id']);
            $table->index(['order_id']);
            $table->index(['transaction_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
