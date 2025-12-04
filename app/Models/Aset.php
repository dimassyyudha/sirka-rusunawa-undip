<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Aset extends Model
{
    use HasFactory;

    protected $table = 'aset'; // Nama tabel singular
    protected $primaryKey = 'aset_id'; // PK kustom

    protected $fillable = [
        'kode_aset',
        'nama_aset',
        'kategori_id',
        'tgl_perolehan',   // Sesuaikan nama kolom
        'nilai_perolehan',
        'kondisi'
    ];

    protected $casts = [
        'tgl_perolehan' => 'date',
        'nilai_perolehan' => 'decimal:2'
    ];

    public function kategoriAset()
    {
        return $this->belongsTo(KategoriAset::class, 'kategori_id', 'kategori_id');
    }

    // Scope Filter (Tetap sama)
    public function scopeFilter(Builder $query, Request $request, array $filterableColumns): Builder
    {
        foreach ($filterableColumns as $column) {
            if ($request->filled($column)) {
                $query->where($column, $request->input($column));
            }
        }
        return $query;
    }
}