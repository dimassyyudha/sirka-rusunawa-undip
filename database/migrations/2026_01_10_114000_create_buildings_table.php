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
        Schema::create('buildings', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->char('building_id', 10)->primary();

            /*
            |--------------------------------------------------------------------------
            | BUILDING INFORMATION
            |--------------------------------------------------------------------------
            */

            $table->string('name', 100);

            $table->string('code', 1)->unique();

            $table->enum('gender_type', [
                'laki-laki',
                'perempuan',
            ]);

            $table->unsignedInteger('total_floors');

            $table->boolean('is_active')->default(true);

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

            $table->index('code');
            $table->index('gender_type');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
