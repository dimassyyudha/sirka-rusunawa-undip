<?php

namespace App\Models;

use App\Models\Aset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MutasiAset extends Model
{
    use HasFactory;

    protected $table = 'mutasi_aset';
    protected $primaryKey = 'mutasi_id';

    protected $fillable = [
        'aset_id',
        'tanggal',
        'jenis_mutasi',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relasi ke Aset
    public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id', 'aset_id');
    }
}