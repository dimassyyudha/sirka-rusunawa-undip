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
        Schema::create('invoices', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->char('invoice_id', 10)->primary();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY
            |--------------------------------------------------------------------------
            */

            $table->char('user_id', 10);

            $table->char('reservation_id', 10);

            $table->char('room_id', 10);

            /*
            |--------------------------------------------------------------------------
            | INVOICE
            |--------------------------------------------------------------------------
            */

            $table->string('invoice_number')->unique();

            $table->enum('invoice_type', [
                'new',
                'extension',
                'transfer',
                'checkout',
                'penalti',
            ]);

            $table->unsignedBigInteger('amount');

            $table->enum('status', [
                'pending',
                'unpaid',
                'paid',
                'expired',
                'cancelled',
                'failed',
            ])->default('pending');

            $table->timestamp('due_at')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->text('description')->nullable();

            /*
            |--------------------------------------------------------------------------
            | TIMESTAMPS
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY CONSTRAINT
            |--------------------------------------------------------------------------
            */

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('reservation_id')
                ->references('reservation_id')
                ->on('reservations')
                ->cascadeOnDelete();

            $table->foreign('room_id')
                ->references('room_id')
                ->on('rooms')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index('invoice_number');
            $table->index('status');
            $table->index('user_id');
            $table->index('reservation_id');
            $table->index('room_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
