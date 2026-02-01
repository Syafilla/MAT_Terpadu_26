<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArsipDetail extends Model
{
   protected $fillable = [
        'arsip_header_id',
        'kode_klasifikasi',
        'indeks',
        'uraian',
        'kurun_waktu',
        'tingkat_perkembangan',
        'jumlah',
        'keterangan',
        'nomor_definitif',
        'nomor_boks',
        'rak',
        'baris'
    ];
    public function header()
    {
        return $this->belongsTo(ArsipHeader::class, 'arsip_header_id');
    }

}

