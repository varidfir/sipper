<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $groups = [
            'KK' => 'KK',
            'AKTA' => 'Akta',
            'KIA' => 'KIA',
            'KTP' => 'KTP',
            'SURAT_PINDAH' => 'Surat Pindah',
            'PEREKAMAN' => 'Perekaman',
        ];

        $totalPermohonan = Permohonan::count();
        $permohonanHariIni = Permohonan::whereDate('tanggal_permohonan', today())->count();
        $permohonanBulanIni = Permohonan::whereMonth('tanggal_permohonan', now()->month)
            ->whereYear('tanggal_permohonan', now()->year)
            ->count();

        $rawTotals = Permohonan::join('jenis_pelayanan', 'permohonan.jenis_pelayanan_id', '=', 'jenis_pelayanan.id')
            ->join('kelompok_pelayanan', 'jenis_pelayanan.kelompok_pelayanan_id', '=', 'kelompok_pelayanan.id')
            ->select('kelompok_pelayanan.kode', DB::raw('count(*) as total'))
            ->groupBy('kelompok_pelayanan.kode')
            ->pluck('total', 'kode');

        $categoryTotals = collect($groups)->mapWithKeys(fn ($label, $code) => [
            $code => [
                'label' => $label,
                'total' => (int) ($rawTotals[$code] ?? 0),
            ],
        ]);

        $recent = Permohonan::with(['jenisPelayanan.kelompokPelayanan', 'kecamatan', 'desa'])
            ->latest('tanggal_permohonan')
            ->latest('id')
            ->limit(8)
            ->get();

        return view('dashboard.index', compact(
            'user', 'totalPermohonan', 'permohonanHariIni', 'permohonanBulanIni', 'categoryTotals', 'recent'
        ));
    }
}
