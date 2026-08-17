<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
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

        $data = $query
            ->selectRaw('
                DATE(tanggal_permohonan) as period,
                COUNT(*) as total
            ')
            ->groupByRaw('DATE(tanggal_permohonan)')
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
        $format = $request->input('format', 'csv');

        $permohonans = Permohonan::with([
            'kecamatan',
            'desa',
            'jenisPelayanan',
            'user'
        ])
            ->latest()
            ->get();

        if ($format === 'csv') {

            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="permohonan.csv"',
            ];

            $content =
                "nomor_permohonan,nama_pemohon,tanggal_permohonan,jenis_pelayanan,kecamatan,desa,keterangan\n";

            foreach ($permohonans as $permohonan) {

                $content .= implode(',', [
                    $this->csvEscape($permohonan->nomor_permohonan),
                    $this->csvEscape($permohonan->nama_pemohon),
                    $permohonan->tanggal_permohonan?->format('Y-m-d'),
                    $this->csvEscape(
                        $permohonan->jenisPelayanan->nama_pelayanan ?? '-'
                    ),
                    $this->csvEscape(
                        $permohonan->kecamatan->nama_kecamatan ?? '-'
                    ),
                    $this->csvEscape(
                        $permohonan->desa->nama_desa ?? '-'
                    ),
                    $this->csvEscape(
                        $permohonan->keterangan ?? '-'
                    ),
                ]) . "\n";
            }

            return new Response($content, 200, $headers);
        }

        return response()->view(
            'permohonan.export',
            compact('permohonans')
        );
    }

    /**
     * Escape data CSV
     */
    private function csvEscape($value)
    {
        $value = (string) $value;

        return '"' . str_replace('"', '""', $value) . '"';
    }
}