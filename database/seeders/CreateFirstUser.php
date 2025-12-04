<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateFirstUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin (Si Paling Berkuasa)
        User::create([
            'name'     => 'Dzakwan (Admin)',
            'email'    => 'admin@desa.id',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Staff (Si Tukang Input)
        User::create([
            'name'     => 'Budi (Staff)',
            'email'    => 'staff@desa.id',
            'password' => Hash::make('password'),
            'role'     => 'staff',
        ]);

        // Pimpinan (Si Pemantau)
        User::create([
            'name'     => 'Pak Kades (Pimpinan)',
            'email'    => 'kades@desa.id',
            'password' => Hash::make('password'),
            'role'     => 'kades',
        ]);
    }
}
