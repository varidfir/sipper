<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermohonanReportController extends Controller
{
    public function recap(Request $request)
    {
        $period = $request->input('period', 'daily');
        $year = $request->input('year', date('Y'));

        $query = Permohonan::query();

        if ($request->filled('year')) {
            $query->whereYear('tanggal_permohonan', $year);
        }

        $data = match ($period) {
            'monthly' => $query->selectRaw('substr(tanggal_permohonan, 1, 7) as period, COUNT(*) as total')
                ->groupBy('period')
                ->orderBy('period')
                ->get(),
            'yearly' => $query->selectRaw('substr(tanggal_permohonan, 1, 4) as period, COUNT(*) as total')
                ->groupBy('period')
                ->orderBy('period')
                ->get(),
            default => $query->selectRaw('tanggal_permohonan as period, COUNT(*) as total')
                ->groupBy('period')
                ->orderBy('period')
                ->get(),
        };

        return view('permohonan.recap', compact('data', 'period', 'year'));
    }

    public function export(Request $request)
    {
        $format = $request->input('format', 'csv');
        $permohonans = Permohonan::with(['kecamatan', 'desa', 'jenisPelayanan', 'user'])
            ->latest()
            ->get();

        if ($format === 'csv') {
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="permohonan.csv"',
            ];

            $content = "nomor_permohonan,nama_pemohon,tanggal_permohonan,jenis_pelayanan,kecamatan,desa,keterangan\n";

            foreach ($permohonans as $permohonan) {
                $content .= implode(',', [
                    $permohonan->nomor_permohonan,
                    $permohonan->nama_pemohon,
                    $permohonan->tanggal_permohonan?->format('Y-m-d'),
                    $permohonan->jenisPelayanan->nama_pelayanan ?? '-',
                    $permohonan->kecamatan->nama_kecamatan ?? '-',
                    $permohonan->desa->nama_desa ?? '-',
                    $permohonan->keterangan,
                ]) . "\n";
            }

            return new Response($content, 200, $headers);
        }

        return response()->view('permohonan.export', compact('permohonans'));
    }
}
