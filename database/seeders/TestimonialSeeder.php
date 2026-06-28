<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Occupant;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [
            'Kamar nyaman dan lingkungan cukup tenang.',
            'Fasilitas cukup membantu kebutuhan harian mahasiswa.',
            'Lokasi strategis dan dekat dengan aktivitas kampus.',
            'Lingkungan aman, bersih, dan nyaman untuk belajar.',
            'Pengalaman tinggal di kamar ini cukup baik.',
            'Harga cukup sesuai dengan fasilitas yang tersedia.',
        ];

        $occupants = Occupant::with(['user', 'room'])
            ->where('status', 'active')
            ->get();

        foreach ($occupants as $occupant) {
            Testimonial::updateOrCreate(
                [
                    'room_id' => $occupant->room_id,
                    'user_id' => $occupant->user_id,
                ],
                [
                    'rating' => rand(4, 5),
                    'comment' => $comments[array_rand($comments)],
                    'is_visible' => true,
                ]
            );
        }
    }
}
