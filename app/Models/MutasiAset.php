<?php

namespace App\Models;

use App\Models\Aset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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

    // --- SCOPE FILTER BARU ---
    public function scopeFilter($query, array $filters)
    {
        // 1. Filter berdasarkan Jenis Mutasi (Dropdown)
        $query->when($filters['jenis_mutasi'] ?? false, function ($query, $jenis) {
            return $query->where('jenis_mutasi', $jenis);
        });

        // 2. Filter berdasarkan Pencarian (Nama Aset atau Kode Aset)
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->whereHas('aset', function($q) use ($search) {
                $q->where('nama_aset', 'like', '%' . $search . '%')
                  ->orWhere('kode_aset', 'like', '%' . $search . '%');
            });
        });
    }
}