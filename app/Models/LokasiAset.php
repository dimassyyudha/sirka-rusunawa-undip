<?php

namespace App\Models;

use App\Models\Aset;
use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LokasiAset extends Model
{
    use HasFactory;

    protected $table = 'lokasi_aset';
    protected $primaryKey = 'lokasi_id';

    protected $fillable = [
        'aset_id',
        'lokasi_text',
        'rt',
        'rw',
        'keterangan'
    ];

    // Relasi: Lokasi ini milik satu Aset
    public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id', 'aset_id');
    }

    public function media()
    {
        return $this->hasOne(Media::class, 'ref_id', 'lokasi_id')
                    ->where('ref_table', 'lokasi_aset')
                    ->latest();
    }
}
