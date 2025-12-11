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
        Schema::create('warga', function (Blueprint $table) {
            $table->id('warga_id'); // Primary Key: warga_id
            $table->string('no_ktp', 16)->unique(); // Unique: no_ktp
            $table->string('nama');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('agama', ['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu']);
            $table->string('pekerjaan');
            $table->string('telp', 15)->nullable(); // Boleh kosong
            $table->string('email')->unique()->nullable(); // Boleh kosong dan harus unik
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};