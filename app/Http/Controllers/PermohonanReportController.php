<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermohonanReportController extends Controller
{
    /**
     * Halaman rekapitulasi permohonan
     */
    public function recap(Request $request)
    {
        // ==============================
        // FILTER
        // ==============================

        $year = $request->input('year', date('Y'));
        $month = $request->input('month');
        $kelompokPelayananId = $request->input('kelompok_pelayanan_id');
        $period = $request->input('period', 'daily');

        // ==============================
        // QUERY DATA
        // ==============================

        $query = Permohonan::query()
            ->with([
                'jenisPelayanan.kelompokPelayanan',
            ]);

        // Filter tahun
        if ($year) {
            $query->whereYear('tanggal_permohonan', $year);
        }

        // Filter bulan
        if ($month) {
            $query->whereMonth('tanggal_permohonan', $month);
        }

        // Filter kelompok / kategori pelayanan
        if ($kelompokPelayananId) {
            $query->whereHas('jenisPelayanan', function ($q) use ($kelompokPelayananId) {
                $q->where('kelompok_pelayanan_id', $kelompokPelayananId);
            });
        }

        // ==============================
        // DATA REKAP
        // ==============================

        $periodExpression = match ($period) {
            'monthly' => "DATE_FORMAT(tanggal_permohonan, '%Y-%m-01')",
            'yearly' => "DATE_FORMAT(tanggal_permohonan, '%Y-01-01')",
            default => 'DATE(tanggal_permohonan)',
        };

        $data = $query
            ->selectRaw("{$periodExpression} as period, COUNT(*) as total")
            ->groupByRaw($periodExpression)
            ->orderBy('period')
            ->get();

        // ==============================
        // DATA KATEGORI
        // ==============================

        $kelompokPelayanans = \App\Models\KelompokPelayanan::query()
            ->orderBy('kode')
            ->get();

        // ==============================
        // DAFTAR TAHUN
        // ==============================

        $years = Permohonan::query()
            ->selectRaw('YEAR(tanggal_permohonan) as year')
            ->whereNotNull('tanggal_permohonan')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        // Jika belum ada data, tetap tampilkan tahun sekarang
        if ($years->isEmpty()) {
            $years = collect([date('Y')]);
        }

        // ==============================
        // DAFTAR BULAN
        // ==============================

        $months = [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return view('permohonan.recap', compact(
            'data',
            'year',
            'month',
            'kelompokPelayananId',
            'period',
            'kelompokPelayanans',
            'years',
            'months'
        ));
    }

    /**
     * Export data permohonan
     */
    public function export(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $month = $request->input('month');
        $kelompokPelayananId = $request->input('kelompok_pelayanan_id');
        $period = $request->input('period', 'daily');

        $query = Permohonan::query()
            ->with('jenisPelayanan');

        if ($year) {
            $query->whereYear('tanggal_permohonan', $year);
        }

        if ($month) {
            $query->whereMonth('tanggal_permohonan', $month);
        }

        if ($kelompokPelayananId) {
            $query->whereHas('jenisPelayanan', function ($q) use ($kelompokPelayananId) {
                $q->where('kelompok_pelayanan_id', $kelompokPelayananId);
            });
        }

        $data = $query
            ->selectRaw('jenis_pelayanan_id, COUNT(*) as total')
            ->groupBy('jenis_pelayanan_id')
            ->orderBy('jenis_pelayanan_id')
            ->get();

        $kelompokPelayanans = \App\Models\KelompokPelayanan::query()
            ->orderBy('kode')
            ->get();

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $selectedKelompok = $kelompokPelayanans->firstWhere('id', $kelompokPelayananId);
        $printedAt = now();
        $petugas = $request->user()?->name ?? 'Nama Petugas';
        $viewData = compact(
            'data',
            'year',
            'month',
            'period',
            'months',
            'selectedKelompok',
            'printedAt',
            'petugas'
        );

        if ($request->boolean('print')) {
            return response()
                ->view('permohonan.recap-pdf', $viewData + ['isPrint' => true])
                ->header('Content-Type', 'text/html; charset=UTF-8');
        }

        $pdf = Pdf::loadView('permohonan.recap-pdf', $viewData)
            ->setPaper('a4', 'portrait');

        $filename = 'rekapitulasi-' . $year . '.pdf';

        return $pdf->download($filename);
    }
}