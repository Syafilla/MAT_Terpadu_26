<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminRekapAtasNamaController extends Controller
{
    public function index(Request $request)
    {
        $tentang = $request->tentang;
        $tahun   = $request->tahun;
        $nama    = $request->nama;

        $query = DB::table('arsip_details as d')
        ->join('arsip_headers as h', 'h.id', '=', 'd.arsip_header_id')
        ->selectRaw("
            h.tentang,
            h.tahun,
            TRIM(
                SUBSTRING_INDEX(
                    SUBSTRING_INDEX(d.uraian, 'Untuk', 1),
                    'Atas Nama',
                    -1
                )
            ) as nama,
            COUNT(*) as total_arsip
        ")
        ->where('d.uraian', 'LIKE', '%Atas Nama%')
        ->groupBy('h.tentang', 'h.tahun', 'nama');



        if ($tentang) {
            $query->where('h.tentang', $tentang);
        }

        if ($tahun) {
            $query->where('h.tahun', $tahun);
        }

        if ($nama) {
            $query->having('nama', 'LIKE', "%$nama%");
        }

        $rekap = $query
            ->havingRaw("nama IS NOT NULL AND nama != ''")
            ->orderBy('h.tahun', 'desc')
            ->get();

        $listTentang = DB::table('arsip_headers')
            ->select('tentang')
            ->distinct()
            ->orderBy('tentang')
            ->get();

        $listTahun = DB::table('arsip_headers')
            ->select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->get();

        return view('admin.rekap.index', compact(
            'rekap',
            'listTentang',
            'listTahun'
        ));
    }

    public function detail(Request $request)
    {
        $nama = $request->nama;

        $data = DB::table('arsip_details as d')
        ->join('arsip_headers as h', 'h.id', '=', 'd.arsip_header_id')
        ->whereRaw("
            TRIM(
                SUBSTRING_INDEX(
                    SUBSTRING_INDEX(d.uraian, 'Untuk', 1),
                    'Atas Nama',
                    -1
                )
            ) = ?
        ", [$nama])
        ->select(
            'd.nomor_definitif',
            'h.tentang',
            'h.tahun',
            'd.uraian',
            'd.created_at'
        )
        ->orderBy('nomor_definitif')
        ->get();


        return response()->json($data);
    }

    
    public function downloadExcel(Request $request)
    {
        $tentang = $request->tentang;
        $tahun   = $request->tahun;

        $query = DB::table('arsip_details as d')
            ->join('arsip_headers as h', 'h.id', '=', 'd.arsip_header_id')
            ->select(
                'h.tentang',
                'h.tahun',
                'd.kode_klasifikasi',
                'd.indeks',
                'd.uraian',
                'd.kurun_waktu',
                'd.tingkat_perkembangan',
                'd.jumlah',
                'd.keterangan',
                'd.nomor_definitif',
                'd.nomor_boks',
                'd.rak',
                'd.baris'
            );

        if ($tentang) {
            $query->where('h.tentang', $tentang);
        }

        if ($tahun) {
            $query->where('h.tahun', $tahun);
        }

        $data = $query->orderBy('d.created_at')->get();

        $templatePath = storage_path(
            'app/template/Form_Daftar_Arsip.xlsx'
        );

        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A4', $tentang);
        $sheet->setCellValue('A5', $tahun);


        $row = 8;
        $no  = 1;

        foreach ($data as $item) {
            $sheet->setCellValue("A{$row}", $no++);
            $sheet->setCellValue("B{$row}", $item->kode_klasifikasi);
            $sheet->setCellValue("C{$row}", $item->indeks);
            $sheet->setCellValue("D{$row}", $item->uraian);
            $sheet->setCellValue("E{$row}", $item->kurun_waktu);
            $sheet->setCellValue("F{$row}", $item->tingkat_perkembangan);
            $sheet->setCellValue("G{$row}", $item->jumlah);
            $sheet->setCellValue("H{$row}", $item->keterangan);
            $sheet->setCellValue("I{$row}", $item->nomor_definitif);
            $sheet->setCellValue("J{$row}", $item->nomor_boks);
            $sheet->setCellValue("K{$row}", $item->rak);
            $sheet->setCellValue("L{$row}", $item->baris);

            $row++;
        }

        $tentangFile = $tentang
            ? preg_replace('/[^A-Za-z0-9\-]/', '_', strtoupper($tentang))
            : 'SEMUA_TENTANG';

        $tahunFile = $tahun ?: 'SEMUA_TAHUN';

        $fileName = "Daftar_Data_Arsip_{$tentangFile}_{$tahunFile}.xlsx";

        return new StreamedResponse(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 200, [
            "Content-Type" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
            "Cache-Control" => "max-age=0",
        ]);
    }
}
