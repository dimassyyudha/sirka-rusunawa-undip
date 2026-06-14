<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_profiles', function (Blueprint $table) {

            $table->ulid('id')->primary();

            /*
            |--------------------------------------------------------------------------
            | RELATION
            |--------------------------------------------------------------------------
            */

            $table->foreignUlid('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignUlid('room_id')
                ->nullable()
                ->constrained('rooms')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | ACADEMIC
            |--------------------------------------------------------------------------
            */

            $table->string('nim', 14)
                ->unique();

            $table->string('fakultas', 100);

            $table->string('jurusan', 100);

            $table->unsignedSmallInteger('angkatan');

            /*
            |--------------------------------------------------------------------------
            | PERSONAL
            |--------------------------------------------------------------------------
            */

            $table->string('tempat_lahir', 100)
                ->nullable();

            $table->date('tanggal_lahir')
                ->nullable();

            $table->string('agama', 50)
                ->nullable();

            $table->text('alamat');

            $table->string('no_hp', 20);
            $table->enum('jalur_pembiayaan', [
                'Non-Bidikmisi/KIP-K',
                'Bidikmisi/KIP-K',
            ])->default('Non-Bidikmisi/KIP-K');

            $table->string('kip_document_path')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | PARENT
            |--------------------------------------------------------------------------
            */

            $table->string('nama_ortu');

            $table->string('no_hp_ortu', 20);

            $table->text('alamat_orang_tua')
                ->nullable();

            $table->string('pekerjaan_orang_tua', 100)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | DOCUMENT
            |--------------------------------------------------------------------------
            */

            $table->string('ktm_path')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | VEHICLE
            |--------------------------------------------------------------------------
            */

            $table->boolean('has_vehicle')
                ->default(false);

            $table->string('vehicle_plate_number', 10)
                ->nullable();

            $table->string('stnk_path')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->enum('status_mahasiswa', [
                'penghuni',
                'tidak_penghuni',
            ])->default('tidak_penghuni');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index(['nim']);
            $table->index(['fakultas']);
            $table->index(['jurusan']);
            $table->index(['status_mahasiswa']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
