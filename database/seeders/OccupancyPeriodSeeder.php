<?php

namespace Database\Seeders;

use App\Models\OccupancyPeriod;
use Illuminate\Database\Seeder;

class OccupancyPeriodSeeder extends Seeder
{
    public function run(): void
    {
        OccupancyPeriod::query()->delete();

        OccupancyPeriod::create([
            'name' => 'Registrasi Ulang Semester Ganjil 2025/2026',
            'semester_type' => 'ganjil',
            'academic_year_start' => 2025,
            'academic_year_end' => 2026,
            'registration_start_date' => '2025-07-01',
            'registration_end_date' => '2025-07-31',
            'lease_start_date' => '2025-08-01',
            'lease_end_date' => '2026-01-31',
            'payment_due_date' => '2025-08-05',
            'status' => 'close',
        ]);

        OccupancyPeriod::create([
            'name' => 'Registrasi Ulang Semester Genap 2025/2026',
            'semester_type' => 'genap',
            'academic_year_start' => 2025,
            'academic_year_end' => 2026,
            'registration_start_date' => '2026-01-01',
            'registration_end_date' => '2026-01-31',
            'lease_start_date' => '2026-02-01',
            'lease_end_date' => '2026-07-31',
            'payment_due_date' => '2026-02-05',
            'status' => 'open',
        ]);
    }
}
