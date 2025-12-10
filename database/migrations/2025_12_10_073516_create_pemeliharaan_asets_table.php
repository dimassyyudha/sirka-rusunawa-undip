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
        Schema::create('pemeliharaan_aset', function (Blueprint $table) {
            $table->id('pemeliharaan_id'); // PK Custom

            // FK ke tabel aset
            $table->foreignId('aset_id')
                  ->constrained('aset', 'aset_id')
                  ->onDelete('cascade');

            $table->date('tanggal');
            $table->text('tindakan');
            $table->decimal('biaya', 15, 2);
            $table->string('pelaksana');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeliharaan_aset');
    }
};
