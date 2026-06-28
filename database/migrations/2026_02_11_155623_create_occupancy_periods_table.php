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
        Schema::create('occupancy_periods', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->char('occupancy_period_id', 10)->primary();

            /*
            |--------------------------------------------------------------------------
            | PERIOD INFORMATION
            |--------------------------------------------------------------------------
            */

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

            $table->date('payment_due_date');

            $table->enum('status', [
                'upcoming',
                'open',
                'close',
            ]);

            $table->text('notes')->nullable();

            /*
            |--------------------------------------------------------------------------
            | TIMESTAMPS
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index('semester_type');
            $table->index('status');
            $table->index([
                'academic_year_start',
                'academic_year_end'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupancy_periods');
    }
};
