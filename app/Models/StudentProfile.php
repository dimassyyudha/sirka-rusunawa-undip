<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    /**
     * Table
     */
    protected $table = 'student_profiles';

    /**
     * Primary Key
     */
    protected $primaryKey = 'student_profile_id';

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * Fillable
     */
    protected $fillable = [
        'student_profile_id',
        'user_id',
        'room_id',
        'nim',
        'fakultas',
        'jurusan',
        'angkatan',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'no_hp',
        'jalur_pembiayaan',
        'kip_document_path',
        'nama_ortu',
        'no_hp_ortu',
        'alamat_orang_tua',
        'pekerjaan_orang_tua',
        'ktm_path',
        'has_vehicle',
        'vehicle_plate_number',
        'stnk_path',
        'status_mahasiswa',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'has_vehicle' => 'boolean',
    ];

    /**
     * Boot
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($studentProfile) {

            if (!$studentProfile->student_profile_id) {

                $last = self::orderByDesc('student_profile_id')->first();

                if (!$last) {
                    $number = 1;
                } else {
                    $number = (int) substr($last->student_profile_id, 3) + 1;
                }

                $studentProfile->student_profile_id =
                    'STD' . str_pad($number, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }

    public function room()
    {
        return $this->belongsTo(
            Room::class,
            'room_id',
            'room_id'
        );
    }
}
