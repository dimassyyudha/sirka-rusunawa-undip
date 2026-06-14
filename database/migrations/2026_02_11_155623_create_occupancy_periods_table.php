<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('occupancy_periods', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('name');

            $table->enum('semester_type', [
                'ganjil',
                'genap',
            ]);

            $table->year('academic_year_start');
            $table->year('academic_year_end');

            $table->date('registration_start_date');
            $table->date('registration_end_date');

            $table->date('lease_start_date');
            $table->date('lease_end_date');

            $table->date('payment_due_date')->nullable();

            $table->enum('status', [
                'upcoming',
                'open',
                'close',
            ])->default('upcoming');

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('occupancy_periods');
    }
};
