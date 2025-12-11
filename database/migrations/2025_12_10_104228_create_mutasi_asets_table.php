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
        Schema::create('mutasi_aset', function (Blueprint $table) {
            $table->id('mutasi_id');

            // FK ke tabel aset
            $table->foreignId('aset_id')
                  ->constrained('aset', 'aset_id')
                  ->onDelete('cascade');

            $table->date('tanggal');
            $table->enum('jenis_mutasi', [
                'Pemindahan',
                'Penghapusan',
                'Perubahan Status',
                'Peminjaman',
                'Pengembalian'
            ]);
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_aset');
    }
};
