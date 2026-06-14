<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'user_id',
        'nim',
        'fakultas',
        'jurusan',
        'angkatan',

        'tempat_lahir',
        'tanggal_lahir',
        'agama',

        'alamat',
        'no_hp',

        'nama_ortu',
        'no_hp_ortu',
        'alamat_orang_tua',
        'pekerjaan_orang_tua',

        'ktm_path',

        'has_vehicle',
        'vehicle_plate_number',
        'stnk_path',

        'status_mahasiswa',
        'room_id',
        'jalur_pembiayaan',
        'kip_document_path',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'angkatan' => 'integer',
        'has_vehicle' => 'boolean',
    ];
    public $incrementing = false;
    protected $keyType = 'string';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
