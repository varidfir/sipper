<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\Request;

class PermohonanReportApiController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', 'daily');
        $year = $request->input('year', date('Y'));
        $perPage = (int) $request->input('per_page', 15);
        $page = (int) $request->input('page', 1);

        $query = Permohonan::query();

        if ($request->filled('year')) {
            $query->whereYear('tanggal_permohonan', $year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('tanggal_permohonan', $request->input('month'));
        }

        if ($request->filled('date')) {
            $query->whereDate('tanggal_permohonan', $request->input('date'));
        }

        if ($request->filled('jenis_pelayanan_id')) {
            $query->where('jenis_pelayanan_id', $request->input('jenis_pelayanan_id'));
        }

        if ($request->filled('kelompok_pelayanan_id')) {
            $query->whereHas('jenisPelayanan', function ($query) use ($request) {
                $query->where('kelompok_pelayanan_id', $request->input('kelompok_pelayanan_id'));
            });
        }

        if ($request->filled('kecamatan_id')) {
            $query->where('kecamatan_id', $request->input('kecamatan_id'));
        }

        if ($request->filled('desa_id')) {
            $query->where('desa_id', $request->input('desa_id'));
        }

        $data = match ($period) {
            'monthly' => $query->selectRaw('substr(tanggal_permohonan, 1, 7) as period, COUNT(*) as total')
                ->groupBy('period')
                ->orderBy('period')
                ->paginate($perPage, ['*'], 'page', $page),
            'yearly' => $query->selectRaw('substr(tanggal_permohonan, 1, 4) as period, COUNT(*) as total')
                ->groupBy('period')
                ->orderBy('period')
                ->paginate($perPage, ['*'], 'page', $page),
            default => $query->selectRaw('tanggal_permohonan as period, COUNT(*) as total')
                ->groupBy('period')
                ->orderBy('period')
                ->paginate($perPage, ['*'], 'page', $page),
        };

        return response()->json([
            'success' => true,
            'message' => 'Data rekap berhasil diambil',
            'data' => $data->items(),
            'pagination' => [
                'current_page' => $data->currentPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
                'last_page' => $data->lastPage(),
            ],
            'filters' => [
                'period' => $period,
                'year' => $year,
                'month' => $request->input('month'),
                'date' => $request->input('date'),
                'jenis_pelayanan_id' => $request->input('jenis_pelayanan_id'),
                'kelompok_pelayanan_id' => $request->input('kelompok_pelayanan_id'),
                'kecamatan_id' => $request->input('kecamatan_id'),
                'desa_id' => $request->input('desa_id'),
            ],
        ]);
    }
}
