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
        Schema::create('reservation_documents', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->char('reservation_id', 10);

            $table->foreign('reservation_id')
                ->references('reservation_id')
                ->on('reservations')
                ->cascadeOnDelete();

            $table->string('document_name');
            $table->string('file_path');

            $table->enum('status', ['pending', 'valid', 'invalid'])
                ->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_documents');
    }
};
