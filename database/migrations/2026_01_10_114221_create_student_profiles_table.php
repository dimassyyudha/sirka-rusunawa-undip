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
        Schema::create('student_profiles', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->char('student_profile_id', 10)->primary();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY
            |--------------------------------------------------------------------------
            */

            $table->char('user_id', 10)->unique();

            $table->char('room_id', 10)
                ->nullable();

            

            /*
            |--------------------------------------------------------------------------
            | ACADEMIC
            |--------------------------------------------------------------------------
            */

            $table->string('nim', 14)->unique();

            $table->string('fakultas', 100);

            $table->string('jurusan', 100);

            $table->unsignedSmallInteger('angkatan');

            /*
            |--------------------------------------------------------------------------
            | PERSONAL
            |--------------------------------------------------------------------------
            */

            $table->string('tempat_lahir', 100)
                ->default('0');

            $table->date('tanggal_lahir')->default('200-01-01');

            $table->string('agama', 50)
                ->default('0');

            $table->text('alamat');

            $table->string('no_hp', 20);

            $table->enum('jalur_pembiayaan', [
                'Non-Bidikmisi/KIP-K',
                'Bidikmisi/KIP-K',
            ]);

            $table->string('kip_document_path')
                ->default('0');

            /*
            |--------------------------------------------------------------------------
            | PARENT
            |--------------------------------------------------------------------------
            */

            $table->string('nama_ortu');

            $table->string('no_hp_ortu', 20);

            $table->text('alamat_orang_tua')->nullable();

            $table->string('pekerjaan_orang_tua', 100)
                ->default('0');

            /*
            |--------------------------------------------------------------------------
            | DOCUMENT
            |--------------------------------------------------------------------------
            */

            $table->string('ktm_path')
                ->default('0');

            /*
            |--------------------------------------------------------------------------
            | VEHICLE
            |--------------------------------------------------------------------------
            */

            $table->boolean('has_vehicle')
                ->default(false);

            $table->string('vehicle_plate_number', 10)
                ->default('0');

            $table->string('stnk_path')
                ->default('0');

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->enum('status_mahasiswa', [
                'penghuni',
                'tidak_penghuni',
            ])->default('tidak_penghuni');

            /*
            |--------------------------------------------------------------------------
            | TIMESTAMP
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

            $table->foreign('room_id')
                ->references('room_id')
                ->on('rooms');

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index('nim');
            $table->index('fakultas');
            $table->index('jurusan');
            $table->index('status_mahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
