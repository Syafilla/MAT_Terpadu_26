<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArsipHeader;
use App\Models\ArsipDetail;
use App\Imports\ArsipImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;


class ArsipController extends Controller
{
    protected function isAdmin()
    {
        return auth()->user()->role === 'admin';
    }
    public function index(Request $request)
    {
        $query = DB::table('arsip_headers as h')
        ->leftJoin('users as u', 'u.id', '=', 'h.user_id')
        ->leftJoin('arsip_details as d', 'd.arsip_header_id', '=', 'h.id')
        ->select(
            'h.tahun',
            'h.tentang',
            'u.username',
            DB::raw('COUNT(d.id) as total_detail')
        )
        ->groupBy('h.tahun', 'h.tentang', 'u.username')
        ->orderBy('h.tahun', 'desc');

        if (!$this->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('tentang')) {
            $query->where('tentang', 'like', '%' . $request->tentang . '%');
        }
        
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('h.tentang', 'like', "%{$q}%")
                    ->orWhere('h.tahun', 'like', "%{$q}%")
                    ->orWhere('d.uraian', 'like', "%{$q}%")
                    ->orWhere('d.indeks', 'like', "%{$q}%")
                    ->orWhere('d.kode_klasifikasi', 'like', "%{$q}%")
                    ->orWhere('d.keterangan', 'like', "%{$q}%");
            });
        }

        $arsips = $query->paginate(20)->withQueryString();
        $isAdmin = $this->isAdmin();

        return view(
        $isAdmin
            ? 'admin.arsip.index'
            : 'user.siarsip.index',
        [
            'arsips'   => $arsips,
            'readonly' => !$isAdmin,
            'isAdmin'  => $isAdmin,
        ]
    );

    }


    public function create()
    {
        if (auth()->user()->role === 'admin') {
            return view('admin.arsip.create');
        }

        return view('user.siarsip.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun'   => 'required|digits:4',
            'tentang' => 'required',
            'details' => 'required|array'
        ]);

        $header = ArsipHeader::firstOrCreate(
            [
                'tahun'   => $request->tahun,
                'tentang' => $request->tentang
            ],
            [
                'user_id' => Auth::id()
            ]
        );

        $lastNumber = ArsipDetail::where('arsip_header_id', $header->id)
            ->max('nomor_definitif') ?? 0;

        foreach ($request->details as $i => $row) {
            ArsipDetail::create([
                'arsip_header_id'   => $header->id,
                'kode_klasifikasi'  => $row['kode_klasifikasi'] ?? null,
                'indeks'            => $row['indeks'] ?? null,
                'uraian'            => $row['uraian'] ?? null,
                'kurun_waktu'       => $row['kurun_waktu'] ?? null,
                'tingkat_perkembangan' => $row['tingkat_perkembangan'] ?? null,
                'jumlah'            => $row['jumlah'] ?? null,
                'keterangan'        => $row['keterangan'] ?? null,
                'nomor_definitif'   => $lastNumber + ($i + 1),
                'nomor_boks'        => $row['nomor_boks'] ?? null,
                'rak'               => $row['rak'] ?? null,
                'baris'             => $row['baris'] ?? null,
            ]);
        }

        return redirect()->route('arsip.index')
            ->with('success', 'Data arsip berhasil ditambahkan');
    }

    public function groupForm($tahun, $tentang)
    {
        $query = ArsipHeader::where('tahun', $tahun)
            ->where('tentang', $tentang);

        if (!$this->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $header = $query->firstOrFail();

        $details = ArsipDetail::where('arsip_header_id', $header->id)
            ->orderBy('nomor_definitif')
            ->get();

        $lastNumber = $details->max('nomor_definitif') ?? 0;

        return view(
            $this->isAdmin()
                ? 'admin.arsip.form'
                : 'user.siarsip.show',
            compact('header', 'details', 'lastNumber')
            + ['readonly' => !$this->isAdmin()]
        );
    }



    public function groupStore(Request $request, $tahun, $tentang)
    {
        DB::transaction(function () use ($request, $tahun, $tentang) {

            $query = ArsipHeader::where('tahun', $tahun)
                ->where('tentang', $tentang)
                ->lockForUpdate();

            if (!$this->isAdmin()) {
                $query->where('user_id', auth()->id());
            }

            $header = $query->firstOrFail();

            $lastNumber = ArsipDetail::where('arsip_header_id', $header->id)
                ->max('nomor_definitif') ?? 0;

            foreach ($request->details as $detail) {

                if (!$this->isAdmin() && !empty($detail['id'])) {
                    continue;
                }

                if (!empty($detail['id'])) {

                    ArsipDetail::where('id', $detail['id'])
                        ->where('arsip_header_id', $header->id)
                        ->update([
                            'kode_klasifikasi'     => $detail['kode_klasifikasi'] ?? null,
                            'indeks'               => $detail['indeks'] ?? null,
                            'uraian'               => $detail['uraian'] ?? null,
                            'kurun_waktu'          => $detail['kurun_waktu'] ?? null,
                            'tingkat_perkembangan' => $detail['tingkat_perkembangan'] ?? null,
                            'jumlah'               => $detail['jumlah'] ?? null,
                            'keterangan'           => $detail['keterangan'] ?? null,
                            'nomor_boks'           => $detail['nomor_boks'] ?? null,
                            'rak'                  => $detail['rak'] ?? null,
                            'baris'                => $detail['baris'] ?? null,
                        ]);
                }
                else {

                    $lastNumber++;

                    ArsipDetail::create([
                        'arsip_header_id'       => $header->id,
                        'kode_klasifikasi'      => $detail['kode_klasifikasi'] ?? null,
                        'indeks'                => $detail['indeks'] ?? null,
                        'uraian'                => $detail['uraian'] ?? null,
                        'kurun_waktu'           => $detail['kurun_waktu'] ?? null,
                        'tingkat_perkembangan'  => $detail['tingkat_perkembangan'] ?? null,
                        'jumlah'                => $detail['jumlah'] ?? null,
                        'keterangan'            => $detail['keterangan'] ?? null,
                        'nomor_definitif'       => $lastNumber,
                        'nomor_boks'            => $detail['nomor_boks'] ?? null,
                        'rak'                   => $detail['rak'] ?? null,
                        'baris'                 => $detail['baris'] ?? null,
                    ]);
                }
            }
        });

        return back()->with('success', 'Data arsip berhasil disimpan');
    }



    public function importExcel(Request $request)
    {
        $request->validate([
            'file'   => 'required|mimes:xlsx,xls',
            'tentang'=> 'required|string',
            'tahun'  => 'required|numeric',
        ]);

        $arsipHeader = ArsipHeader::firstOrCreate(
            [
                'tahun'   => $request->tahun,
                'tentang' => $request->tentang,
            ],
            [
                'user_id' => auth()->id(),
            ]
        );

        Excel::import(
            new ArsipImport($arsipHeader->id),
            $request->file('file')
        );

        return back()->with('success', 'Import arsip berhasil');
    }


    public function deleteGroup(Request $request)
    {
        abort_unless($this->isAdmin(), 403);
        
        $request->validate([
            'tahun'   => 'required|digits:4',
            'tentang' => 'required'
        ]);

        $headers = ArsipHeader::where('tahun', $request->tahun)
            ->where('tentang', $request->tentang)
            ->get();

        if ($headers->isEmpty()) {
            return back()->with('error', 'Data arsip tidak ditemukan');
        }

        foreach ($headers as $header) {
            ArsipDetail::where('arsip_header_id', $header->id)->delete();
            $header->delete();
        }

        return redirect()
            ->route('arsip.index')
            ->with('success', 'Seluruh arsip berhasil dihapus');
    }

    public function preview(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $spreadsheet = IOFactory::load(
            $request->file('file')->getPathname()
        );
        $sheet = $spreadsheet->getActiveSheet();

        $tentang = trim($sheet->getCell('A4')->getValue());
        $tahun   = trim($sheet->getCell('A5')->getValue());

        if (!$tentang || !$tahun) {
            return back()->with(
                'error',
                'Format file tidak sesuai (Tentang baris 4, Tahun baris 5)'
            );
        }

        $rows = [];
        $highestRow = $sheet->getHighestRow();

        for ($row = 8; $row <= $highestRow; $row++) {
            $data = [
                'kode_klasifikasi'     => $sheet->getCell("A$row")->getValue(),
                'indeks'               => $sheet->getCell("B$row")->getValue(),
                'uraian'               => $sheet->getCell("C$row")->getValue(),
                'kurun_waktu'          => $sheet->getCell("D$row")->getValue(),
                'tingkat_perkembangan' => $sheet->getCell("E$row")->getValue(),
                'jumlah'               => $sheet->getCell("F$row")->getValue(),
                'keterangan'           => $sheet->getCell("G$row")->getValue(),
                'nomor_boks'           => $sheet->getCell("H$row")->getValue(),
                'rak'                  => $sheet->getCell("I$row")->getValue(),
                'baris'                => $sheet->getCell("J$row")->getValue(),
            ];

            if (!array_filter($data)) {
                continue;
            }

            $rows[] = $data;
        }

        if (count($rows) === 0) {
            return back()->with('error', 'Data arsip kosong');
        }

        $path = $request->file('file')->store('temp');

        return view('siarsip.preview', compact(
            'tentang',
            'tahun',
            'rows',
            'path'
        ));
    }
    

}
