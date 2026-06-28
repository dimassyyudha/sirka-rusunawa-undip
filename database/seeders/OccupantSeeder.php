<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Occupant;
use App\Models\PaymentTransaction;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\OccupancyPeriod;

class OccupantSeeder extends Seeder
{
    private function fakeAlamatIndonesia(): string
    {
        $jalan = [
            'Jl. Diponegoro',
            'Jl. Sudirman',
            'Jl. Ahmad Yani',
            'Jl. Gajah Mada',
            'Jl. Imam Bonjol',
            'Jl. Pemuda',
            'Jl. Pahlawan',
            'Jl. Soekarno Hatta',
            'Jl. Merdeka',
            'Jl. Kalitekuk',
        ];

        $kelurahan = [
            'Tembalang',
            'Bulusan',
            'Pedalangan',
            'Banyumanik',
            'Ngaliyan',
            'Candisari',
            'Jatingaleh',
            'Sampangan',
            'Ngabul',
            'Krapyak',
        ];

        $kecamatan = [
            'Tembalang',
            'Banyumanik',
            'Tahunan',
            'Candisari',
            'Ngaliyan',
            'Pedurungan',
            'Semarang Barat',
        ];

        $kota = [
            'Kota Semarang',
            'Kabupaten Jepara',
            'Kabupaten Kendal',
            'Kabupaten Demak',
            'Kabupaten Grobogan',
        ];

        return sprintf(
            '%s No. %d, Kel. %s, Kec. %s, %s, Jawa Tengah',
            fake()->randomElement($jalan),
            rand(1, 250),
            fake()->randomElement($kelurahan),
            fake()->randomElement($kecamatan),
            fake()->randomElement($kota),
        );
    }
    public function run(): void
    {
        $rooms = Room::with('floor')
            ->where('status', 'tersedia')
            ->take(30)
            ->get();

        $students = [

            ['nim' => '24060120140157', 'name' => 'MUHAMMAD NAUFAL'],
            ['nim' => '24060122130081', 'name' => 'ALDISAR GIBRAN'],
            ['nim' => '24060122120033', 'name' => 'ZIKRY ALFAHRI AKRAM'],
            ['nim' => '24060122130045', 'name' => 'MUHAMMAD NAUFAL RIFQI SETIAWAN'],
            ['nim' => '24060122130095', 'name' => 'SYARIFUL HANIF SETIAWAN'],
            ['nim' => '24060122130090', 'name' => 'YESAYA RUDOLF SUSANTO WIDYANTO'],
            ['nim' => '24060122130072', 'name' => 'QUN ALFADRIAN SETYOWAHYU PUTRO'],

            ['nim' => '24060122130084', 'name' => 'NASHWAN ADENAYA'],
            ['nim' => '24060122140165', 'name' => 'FARREL ARDANA JATI'],
            ['nim' => '24060122130077', 'name' => 'FENDI ARDIANTO'],
            ['nim' => '24060122140179', 'name' => 'FARREL AMIRTA IRBAH'],
            ['nim' => '24060122120018', 'name' => 'MUHAMMAD NAUFAL IZZUDIN'],
            ['nim' => '24060122130083', 'name' => 'MUHAMMAD AHSAN YUDHISTIRA'],
            ['nim' => '24060122140044', 'name' => 'DAFFA FAIRUZ ANNIZARI'],
            ['nim' => '24060122140113', 'name' => 'BIMA ADITYA ARYONO'],
            ['nim' => '24060122120014', 'name' => "RACHMAD RIFA'I"],
            ['nim' => '24060122130080', 'name' => 'ALFONSO CLEMENT SUTANTIO'],
            ['nim' => '24060122120006', 'name' => 'VINCENTIUS SETYAWAN WIDYAHADI'],
            ['nim' => '24060122140109', 'name' => 'JEREMIA JOEL RICHARD RAMALAEL'],
            ['nim' => '24060122120004', 'name' => 'ABISATYA HASTARANGGA PRADANA'],
            ['nim' => '24060122130059', 'name' => 'ARIFIN NURMUHAMMAD HARIS'],
            ['nim' => '24060122120005', 'name' => 'ADITYA HAIDAR FAISHAL'],
            ['nim' => '24060122120035', 'name' => 'ABDUL MAJID'],
            ['nim' => '24060122120034', 'name' => 'DZU SUNAN MUHAMMAD'],
            ['nim' => '24060122120030', 'name' => 'BERNARDO NANDANIAR SUNIA'],
            ['nim' => '24060122130068', 'name' => 'MOHAMAD FAISAL RIZKI'],
            ['nim' => '24060122120019', 'name' => 'GHIRSAN AHDANI'],
            ['nim' => '24060122130052', 'name' => 'MUHAMMAD REYNALDI AKBAR'],
            ['nim' => '24060122140042', 'name' => 'MUHAMMAD FAKHRELL ANDREAZ'],
            ['nim' => '24060122120025', 'name' => 'DIMAS YUDHA SAPUTRA'],
            ['nim' => '24060122120012', 'name' => 'FAISHAL BARIQ MAULANA'],
            ['nim' => '24060122130069', 'name' => 'YAHYA ILHAM RIYADI'],
            ['nim' => '24060122140104', 'name' => 'ALWEY HAKIM'],
            ['nim' => '24060122130079', 'name' => 'SULTAN ALAMSYAH BORNEO ARIFIN'],
            ['nim' => '24060122140103', 'name' => 'MUFLIH MUHAMMAD IMADUDDIN'],
            ['nim' => '24060121140176', 'name' => 'FERNANDA GALIH SAPUTRA'],
            ['nim' => '24060122130064', 'name' => "MUHAMMAD DZAKY MU'AMMAR"],
            ['nim' => '24060122140160', 'name' => 'AHMAD MUHAMMAD GHIFAR HIRAWAN'],

        ];
        $occupancyPeriod = OccupancyPeriod::first();

        if (!$occupancyPeriod) {
            throw new \Exception('Data occupancy_periods belum tersedia.');
        }
        $studentIndex = 0;

        foreach ($rooms as $room) {

            $capacity = (int) ($room->floor->room_capacity ?? 2);

            $occupantsNeeded = $capacity > 1 ? 2 : 1;

            for ($i = 1; $i <= $occupantsNeeded; $i++) {
                if (!isset($students[$studentIndex])) {
                    break 2;
                }

                $student = $students[$studentIndex];

                $user = User::create([
                    'name' => $student['name'],
                    'email' => strtolower(
                        str_replace(' ', '.', $student['nim'])
                    ) . '@gmail.com',

                    'number_phone' => '08' . fake()->numerify('##########'),

                    'password' => bcrypt('password'),

                    'role' => 'mahasiswa',
                ]);

                $studentIndex++;
                // $user = User::create([
                //     'name' => fake()->name(),
                //     'email' => fake()->unique()->safeEmail(),
                //     'number_phone' => '08' . fake()->numerify('##########'),
                //     'password' => Hash::make('password'),
                //     'role' => 'mahasiswa',
                // ]);

                $profile = StudentProfile::create([
                    'user_id' => $user->user_id,

                    'nim' => $student['nim'],
                    'fakultas' => 'FSM',
                    'jurusan' => 'Informatika',
                    'angkatan' => 2024,

                    'tempat_lahir' => 'Semarang',
                    'tanggal_lahir' => '2004-01-01',
                    'agama' => 'Islam',

                    'alamat' => $this->fakeAlamatIndonesia(),

                    'alamat_orang_tua' => $this->fakeAlamatIndonesia(),
                    'no_hp' => $user->number_phone,

                    'nama_ortu' => fake()->name(),
                    'no_hp_ortu' => '08' . fake()->numerify('##########'),
                    // 'alamat_orang_tua' => fake()->address(),
                    'pekerjaan_orang_tua' => 'ASN',

                    'jalur_pembiayaan' => fake()->randomElement([
                        'Bidikmisi/KIP-K',
                        'Non-Bidikmisi/KIP-K',
                    ]),

                    'ktm_path' => '0',
                    'kip_document_path' => '0',

                    'has_vehicle' => false,
                    'vehicle_plate_number' => '0',
                    'stnk_path' => '0',

                    'status_mahasiswa' => 'penghuni',

                    'room_id' => $room->room_id,
                ]);

                $duration = 6;

                $pricePerMonth = (int) $room->floor->monthly_price;

                $totalPrice = $pricePerMonth * $duration;

                $occupancyType =
                    $capacity > 1
                    ? 'shared'
                    : 'private';

                $slotUsed =
                    $occupancyType === 'private'
                    ? $capacity
                    : 1;

                $reservation = Reservation::create([

                    'reservation_code' => strtoupper(Str::random(8)),

                    'room_id' => $room->room_id,

                    'user_id' => $user->user_id,

                    'occupancy_period_id' => $occupancyPeriod->occupancy_period_id,

                    'contact_name' => $user->name,
                    'contact_phone' => $user->number_phone,
                    'contact_email' => $user->email,

                    'guest_name' => $user->name,
                    'guest_nim' => $profile->nim,
                    'guest_faculty' => $profile->fakultas,
                    'guest_major' => $profile->jurusan,
                    'guest_intake_year' => $profile->angkatan,

                    'parent_name' => $profile->nama_ortu,
                    'parent_phone' => $profile->no_hp_ortu,

                    'start_date' => now(),
                    'end_date' => now()->addMonths($duration),

                    'duration_month' => $duration,

                    'payment_term' => $profile->jalur_pembiayaan === 'Bidikmisi/KIP-K'
                        ? 2
                        : 1,

                    'occupancy_type' => $occupancyType,

                    'slot_used' => $slotUsed,

                    'price_per_month' => $pricePerMonth,

                    'total_price' => $totalPrice,

                    'reservation_type' => 'new',

                    'status' => 'active',
                ]);

                $invoice = Invoice::create([

                    'user_id' => $user->user_id,

                    'reservation_id' => $reservation->reservation_id,

                    'room_id' => $room->room_id,

                    'invoice_number' =>
                    'INV-' .
                        now()->format('Ymd') .
                        '-' .
                        rand(1000, 9999),

                    'invoice_type' => 'new',

                    'amount' => $totalPrice,

                    'status' => 'paid',

                    'paid_at' => now(),

                    'due_at' => now()->addDays(7),
                ]);

                PaymentTransaction::create([

                    'invoice_id' => $invoice->invoice_id,

                    'user_id' => $user->user_id,

                    'order_hash' => hash(
                        'sha256',
                        $invoice->invoice_number . $user->user_id
                    ),

                    'order_id' => $invoice->invoice_number,



                    'payment_gateway' => 'midtrans',

                    'gross_amount' => $invoice->amount,

                    'payment_type' => fake()->randomElement([
                        'bank_transfer',
                        'qris',
                        'gopay',
                    ]),

                    'transaction_status' => 'settlement',

                    // 'raw_response' => json_encode([
                    //     'status_code' => 200,
                    //     'transaction_status' => 'settlement',
                    // ]),

                    'snap_token' => null,

                    'expired_at' => now()->addDay(),

                    'paid_at' => now(),
                ]);

                Occupant::create([

                    'user_id' => $user->user_id,

                    'room_id' => $room->room_id,

                    'reservation_id' => $reservation->reservation_id,

                    'status' => 'active',

                    'start_date' => now(),

                    'end_date' => now()->addMonths($duration),
                ]);
            }

            $room->update([
                'occupied' => $occupantsNeeded,

                'status' =>
                $occupantsNeeded >= $capacity
                    ? 'penuh'
                    : 'tersedia',
            ]);
        }
    }
}
