<?php

namespace App\Models;

use App\Models\Aset;
use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PemeliharaanAset extends Model
{
    use HasFactory;

    protected $table = 'pemeliharaan_aset';
    protected $primaryKey = 'pemeliharaan_id';

    protected $fillable = [
        'aset_id',
        'tanggal',
        'tindakan',
        'biaya',
        'pelaksana'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'biaya'   => 'decimal:2'
    ];

    // Relasi ke Aset
    public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id', 'aset_id');
    }

    // Relasi ke Media (HAS MANY karena Multiple Upload)
    public function bukti()
    {
        return $this->hasMany(Media::class, 'ref_id', 'pemeliharaan_id')
                    ->where('ref_table', 'pemeliharaan_aset')
                    ->orderBy('sort_order', 'asc');
    }
}
