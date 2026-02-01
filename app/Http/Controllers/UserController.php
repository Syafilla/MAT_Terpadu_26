<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ArsipDetail;
use App\Models\ArsipHeader;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'user')
            ->orderBy('username')
            ->get();

        $userId = $request->query('user_id');

        if ($userId) {
            $isPetugas = User::where('id', $userId)
                ->where('role', 'user')
                ->exists();

            if (!$isPetugas) {
                $userId = null;
            }
        }

        $onlineUsers = User::where('last_activity', '>=', now()->subMinutes(5))->count();
        $totalUser = User::count();
        $totalBerkas = ArsipDetail::count();
        $totalIndex = ArsipHeader::distinct('tentang')->count('tentang');

        $tahunSekarang = Carbon::now()->year;
        $totalArsipTahunIni = ArsipHeader::where('tahun', $tahunSekarang)->count();


        $tanggalHariIni = Carbon::today();
        $tanggalKemarin = Carbon::yesterday();

        $queryHariIni = ArsipDetail::whereDate('created_at', $tanggalHariIni)
            ->where('is_import', 0);

        $queryKemarin = ArsipDetail::whereDate('created_at', $tanggalKemarin)
            ->where('is_import', 0);

        if ($userId) {
            $queryHariIni->whereHas('header', fn ($q) => $q->where('user_id', $userId));
            $queryKemarin->whereHas('header', fn ($q) => $q->where('user_id', $userId));
        }

        $totalHariIni = $queryHariIni->count();
        $totalKemarin = $queryKemarin->count();

        $persentase = $totalKemarin == 0
            ? ($totalHariIni > 0 ? 100 : 0)
            : (($totalHariIni - $totalKemarin) / $totalKemarin) * 100;


        $awalMingguIni = Carbon::now()->startOfWeek();
        $akhirMingguIni = Carbon::now()->endOfWeek();

        $awalMingguLalu = Carbon::now()->subWeek()->startOfWeek();
        $akhirMingguLalu = Carbon::now()->subWeek()->endOfWeek();

        $queryMingguIni = ArsipDetail::whereBetween('created_at', [$awalMingguIni, $akhirMingguIni])
            ->where('is_import', 0);

        $queryMingguLalu = ArsipDetail::whereBetween('created_at', [$awalMingguLalu, $akhirMingguLalu])
            ->where('is_import', 0);

        if ($userId) {
            $queryMingguIni->whereHas('header', fn ($q) => $q->where('user_id', $userId));
            $queryMingguLalu->whereHas('header', fn ($q) => $q->where('user_id', $userId));
        }

        $weeklyNow  = $queryMingguIni->count();
        $weeklyLast = $queryMingguLalu->count();

        $petugasData = ArsipDetail::selectRaw('
            users.username AS name,
            COUNT(arsip_details.id) AS total
        ')
        ->join('arsip_headers', 'arsip_headers.id', '=', 'arsip_details.arsip_header_id')
        ->join('users', 'users.id', '=', 'arsip_headers.user_id')
        ->whereBetween('arsip_details.created_at', [$awalMingguIni, $akhirMingguIni])
        ->where('arsip_details.is_import', 0)
        ->where('users.role', 'user')
        ->groupBy('users.username')
        ->orderByDesc('total')
        ->get();

    /**
     * TOTAL INPUT MINGGUAN (SEMUA PETUGAS)
     */
    $totalInputMingguan = $petugasData->sum('total');

    /**
     * DATA UNTUK CHART (PERSENTASE)
     */
    $chartData = $petugasData->map(function ($item) use ($totalInputMingguan) {
        return [
            'name' => $item->name,
            'total' => $item->total,
            'percent' => $totalInputMingguan > 0
                ? round(($item->total / $totalInputMingguan) * 100, 1)
                : 0
        ];
    });
    $arsipPerTahun = ArsipHeader::selectRaw('tahun, COUNT(*) as total')
        ->whereNotNull('tahun')
        ->groupBy('tahun')
        ->orderBy('tahun', 'asc')
        ->get();

    $chartTahun = $arsipPerTahun->pluck('tahun');
    $chartTotal = $arsipPerTahun->pluck('total');
    



        return view('admin.dashboard', compact(
            'users',
            'onlineUsers',
            'totalUser',
            'totalBerkas',
            'totalIndex',
            'totalArsipTahunIni',
            'totalHariIni',
            'totalKemarin',
            'persentase',
            'weeklyNow',
            'weeklyLast',
            'petugasData',
            'totalInputMingguan',
            'chartData',
            'chartTahun',
            'chartTotal',
            'userId'
        ));
    }

   public function dashboardUser()
    {
        $userId = auth()->id();

        $totalArsipUser = ArsipHeader::where('user_id', $userId)->count();

        $weeklyArsipUser = ArsipHeader::where('user_id', $userId)
            ->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count();

        $hariIni = ArsipHeader::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())->count();

        $kemarin = ArsipHeader::where('user_id', $userId)
            ->whereDate('created_at', Carbon::yesterday())->count();

        $persentase = $kemarin == 0
            ? ($hariIni > 0 ? 100 : 0)
            : (($hariIni - $kemarin) / $kemarin) * 100;

        $onlineUsers = User::where('last_activity', '>=', now()->subMinutes(5))->count();
        $totalUsers  = User::count();
        $persenOnline = $totalUsers == 0 ? 0 : round(($onlineUsers / $totalUsers) * 100, 1);

        return view('user.dashboard', compact(
            'totalArsipUser',
            'weeklyArsipUser',
            'hariIni',
            'kemarin',
            'persentase',
            'persenOnline'
        ));
    }



   public function userdex(Request $request)
    {
        $role = $request->get('role', 'user');

        if (!in_array($role, ['user', 'admin'])) {
            $role = 'user';
        }

        $users = User::where('role', $role)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users.index', compact('users', 'role'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|unique:users',
                'nip'      => 'nullable|unique:users',
                'role'     => 'required'
            ]);

            User::create([
                'username' => $request->username,
                'nip'      => $request->nip,
                'role'     => $request->role,
                'password' => null
            ]);


            return redirect()
                ->route('admin.user')
                ->with('success', 'User berhasil ditambahkan');

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
    public function arsipEdit($id)
    {
        $arsip = ArsipHeader::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('user.arsip.edit', compact('arsip'));
    }


    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'username' => 'required|unique:users,username,' . $user->id,
                'nip'      => 'nullable|unique:users,nip,' . $user->id,
                'role'     => 'required'
            ]);

            $data = $request->only('username', 'nip', 'role');

            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return redirect()
                ->route('admin.user')
                ->with('success', 'User berhasil diperbarui');

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()
            ->route('admin.user')
            ->with('success', 'User berhasil dihapus');
    }

}
