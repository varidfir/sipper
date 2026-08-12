<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\JenisPelayanan;
use App\Models\Kecamatan;
use App\Models\KelompokPelayanan;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PermohonanController extends Controller
{
    public function index(Request $request)
    {
        $query = Permohonan::with(['kecamatan', 'desa', 'jenisPelayanan.kelompokPelayanan', 'user'])
            ->latest('tanggal_permohonan')
            ->latest('id');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nomor_permohonan', 'like', "%{$search}%")
                    ->orWhere('nama_pemohon', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('tanggal_permohonan', $request->date);
        }

        if ($request->filled('month')) {
            $query->whereMonth('tanggal_permohonan', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('tanggal_permohonan', $request->year);
        }

        if ($request->filled('jenis_pelayanan_id')) {
            $query->where('jenis_pelayanan_id', $request->jenis_pelayanan_id);
        }

        if ($request->filled('kelompok_pelayanan_id')) {
            $query->whereHas('jenisPelayanan', function ($q) use ($request) {
                $q->where('kelompok_pelayanan_id', $request->kelompok_pelayanan_id);
            });
        }

        if ($request->filled('kecamatan_id')) {
            $query->where('kecamatan_id', $request->kecamatan_id);
        }

        if ($request->filled('desa_id')) {
            $query->where('desa_id', $request->desa_id);
        }

        $permohonans = $query->get();

        $kelompokPelayanans = KelompokPelayanan::aktif()
            ->with(['jenisPelayanans' => fn ($q) => $q->aktif()->orderBy('id')])
            ->orderBy('id')
            ->get();

        $kecamatans = Kecamatan::orderBy('nama_kecamatan')->get();
        $desas = Desa::orderBy('nama_desa')->get();

        return view('permohonan.index', compact(
            'permohonans',
            'kelompokPelayanans',
            'kecamatans',
            'desas'
        ));
    }

    public function create()
    {
        $kelompokPelayanans = KelompokPelayanan::aktif()
            ->with(['jenisPelayanans' => fn ($q) => $q->aktif()->orderBy('id')])
            ->orderBy('id')
            ->get();

        $kecamatans = Kecamatan::orderBy('nama_kecamatan')->get();
        $desas = Desa::orderBy('nama_desa')->get();

        return view('permohonan.form', compact(
            'kelompokPelayanans',
            'kecamatans',
            'desas'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate(Permohonan::rules());

        $this->validateDesaBelongsToKecamatan(
            (int) $data['desa_id'],
            (int) $data['kecamatan_id']
        );

        $jenis = JenisPelayanan::with('kelompokPelayanan')
            ->aktif()
            ->findOrFail($data['jenis_pelayanan_id']);

        $this->validateJenisPelayanan($request, $jenis);

        $data['nomor_permohonan'] = $this->generateNomorPermohonan($data['tanggal_permohonan']);
        $data['user_id'] = Auth::id();
        $data['detail_data'] = $request->input('detail_data', []);
        $data['keterangan'] = $request->input('keterangan');

        Permohonan::create($data);

        return redirect()
            ->route('permohonan.index')
            ->with('status', "Permohonan {$data['nomor_permohonan']} berhasil disimpan.");
    }

    public function show(Permohonan $permohonan)
    {
        $permohonan->load(['kecamatan', 'desa', 'jenisPelayanan.kelompokPelayanan', 'user']);

        return view('permohonan.show', compact('permohonan'));
    }

    public function edit(Permohonan $permohonan)
    {
        $kelompokPelayanans = KelompokPelayanan::aktif()
            ->with(['jenisPelayanans' => fn ($q) => $q->aktif()->orderBy('id')])
            ->orderBy('id')
            ->get();

        $kecamatans = Kecamatan::orderBy('nama_kecamatan')->get();
        $desas = Desa::orderBy('nama_desa')->get();

        return view('permohonan.form', compact(
            'permohonan',
            'kelompokPelayanans',
            'kecamatans',
            'desas'
        ));
    }

    public function update(Request $request, Permohonan $permohonan)
    {
        $data = $request->validate(Permohonan::rules($permohonan->id));

        $this->validateDesaBelongsToKecamatan(
            (int) $data['desa_id'],
            (int) $data['kecamatan_id']
        );

        $jenis = JenisPelayanan::with('kelompokPelayanan')
            ->aktif()
            ->findOrFail($data['jenis_pelayanan_id']);

        $this->validateJenisPelayanan($request, $jenis);

        // Nomor permohonan tidak berubah ketika data diedit.
        $data['nomor_permohonan'] = $permohonan->nomor_permohonan;
        $data['user_id'] = Auth::id();
        $data['detail_data'] = $request->input('detail_data', []);
        $data['keterangan'] = $request->input('keterangan');

        $permohonan->update($data);

        return redirect()
            ->route('permohonan.index')
            ->with('status', 'Data permohonan berhasil diperbarui.');
    }

    public function destroy(Permohonan $permohonan)
    {
        $permohonan->delete();

        return redirect()
            ->route('permohonan.index')
            ->with('status', 'Data permohonan berhasil dihapus.');
    }

    private function validateDesaBelongsToKecamatan(int $desaId, int $kecamatanId): void
    {
        $desa = Desa::find($desaId);

        if (! $desa || (int) $desa->kecamatan_id !== $kecamatanId) {
            throw ValidationException::withMessages([
                'desa_id' => 'Desa/Kelurahan tidak sesuai dengan Kecamatan yang dipilih.',
            ]);
        }
    }

    private function validateJenisPelayanan(Request $request, JenisPelayanan $jenis): void
    {
        $group = $jenis->kelompokPelayanan?->kode;

        if (! $group) {
            throw ValidationException::withMessages([
                'jenis_pelayanan_id' => 'Kategori pelayanan tidak valid.',
            ]);
        }

        if ($group === 'AKTA' && ! $request->filled('detail_data.nomor_kendali')) {
            throw ValidationException::withMessages([
                'detail_data.nomor_kendali' => 'No. Kendali wajib diisi untuk pelayanan akta.',
            ]);
        }
    }

    private function generateNomorPermohonan(string $tanggal): string
    {
        $prefix = 'SIPPER-' . date('Ymd', strtotime($tanggal));

        $lastNumber = Permohonan::whereDate('tanggal_permohonan', $tanggal)
            ->select('nomor_permohonan')
            ->orderByDesc('id')
            ->value('nomor_permohonan');

        $sequence = 1;

        if ($lastNumber && preg_match('/-(\d{4})$/', $lastNumber, $match)) {
            $sequence = (int) $match[1] + 1;
        }

        do {
            $number = $prefix . '-' . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
            $sequence++;
        } while (Permohonan::where('nomor_permohonan', $number)->exists());

        return $number;
    }
}
