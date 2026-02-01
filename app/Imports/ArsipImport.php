<?php

namespace App\Imports;

use App\Models\ArsipDetail;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class ArsipImport implements ToCollection
{
    protected $arsipHeaderId;

    public function __construct($arsipHeaderId)
    {
        $this->arsipHeaderId = $arsipHeaderId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows->skip(7) as $row) {

            if (empty($row[3])) {
                continue;
            }

            ArsipDetail::create([
                'arsip_header_id'      => $this->arsipHeaderId,
                'kode_klasifikasi'     => $row[1] ?? null,
                'indeks'               => $row[2] ?? null,
                'uraian'               => $row[3] ?? null,
                'kurun_waktu'          => $row[4] ?? null,
                'tingkat_perkembangan' => $row[5] ?? null,
                'jumlah'               => $row[6] ?? null,
                'keterangan'           => $row[7] ?? null,
                'nomor_definitif'      => $row[8] ?? null,
                'nomor_boks'           => $row[9] ?? null,
                'rak'                  => $row[10] ?? null,
                'baris'                => $row[11] ?? null,
                'is_import'  => 1
            ]);
        }
    }
}
