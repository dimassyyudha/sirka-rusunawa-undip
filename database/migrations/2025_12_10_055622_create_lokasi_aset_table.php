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
        Schema::create('lokasi_aset', function (Blueprint $table) {
            $table->id('lokasi_id');

            $table->foreignId('aset_id')
                  ->constrained('aset', 'aset_id')
                  ->onDelete('cascade');

            $table->string('lokasi_text');
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_aset');
    }
};
