<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class DesaController extends Controller
{
    public function index()
    {
        $desas = Desa::with('kecamatan')->latest()->get();
        return view('master.desa.index', compact('desas'));
    }

    public function create()
    {
        $kecamatans = Kecamatan::all();
        return view('master.desa.form', compact('kecamatans'));
    }

    public function store(Request $request)
    {
        $data = $request->only('kecamatan_id', 'kecamatan_manual', 'nama_desa');

        $kecamatanId = $data['kecamatan_id'] ?? null;
        $manualName = trim((string) ($data['kecamatan_manual'] ?? ''));
        $namaDesa = trim((string) ($data['nama_desa'] ?? ''));

        if ($namaDesa === '') {
            return back()->withErrors(['nama_desa' => 'Nama desa wajib diisi.'])->withInput();
        }

        if (empty($kecamatanId) && $manualName !== '') {
            $kecamatan = Kecamatan::firstOrCreate(['nama_kecamatan' => $manualName]);
            $kecamatanId = $kecamatan->id;
        }

        if (empty($kecamatanId)) {
            return back()->withErrors(['kecamatan_id' => 'Kecamatan wajib dipilih atau ditulis manual.'])->withInput();
        }

        Desa::create([
            'kecamatan_id' => $kecamatanId,
            'nama_desa' => $namaDesa,
        ]);

        return redirect()->route('desa.index')->with('status', 'Desa berhasil ditambahkan.');
    }

    public function edit(Desa $desa)
    {
        $kecamatans = Kecamatan::all();
        return view('master.desa.form', compact('desa', 'kecamatans'));
    }

    public function update(Request $request, Desa $desa)
    {
        $data = $request->only('kecamatan_id', 'kecamatan_manual', 'nama_desa');

        $kecamatanId = $data['kecamatan_id'] ?? null;
        $manualName = trim((string) ($data['kecamatan_manual'] ?? ''));
        $namaDesa = trim((string) ($data['nama_desa'] ?? ''));

        if ($namaDesa === '') {
            $namaDesa = $desa->nama_desa;
        }

        if (empty($kecamatanId) && $manualName !== '') {
            $kecamatan = Kecamatan::firstOrCreate(['nama_kecamatan' => $manualName]);
            $kecamatanId = $kecamatan->id;
        }

        if (empty($kecamatanId)) {
            $kecamatanId = $desa->kecamatan_id;
        }

        $desa->update([
            'kecamatan_id' => $kecamatanId,
            'nama_desa' => $namaDesa,
        ]);

        return redirect()->route('desa.index')->with('status', 'Desa berhasil diperbarui.');
    }

    public function destroy(Desa $desa)
    {
        $desa->delete();
        return redirect()->route('desa.index')->with('status', 'Desa berhasil dihapus.');
    }
}
