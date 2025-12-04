<?php

namespace App\Models;

use App\Models\Aset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriAset extends Model
{
    use HasFactory;

    protected $table = 'kategori_aset'; // Nama tabel singular
    protected $primaryKey = 'kategori_id'; // PK kustom

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
    ];

    /**
     * Relasi ke model Aset (satu kategori punya banyak aset)
     */
    public function asets()
    {
        return $this->hasMany(Aset::class, 'kategori_id', 'kategori_id');
    }
}
