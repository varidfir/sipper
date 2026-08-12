<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function index()
    {
        $kecamatans = Kecamatan::latest()->get();
        return view('master.kecamatan.index', compact('kecamatans'));
    }

    public function create()
    {
        return view('master.kecamatan.form');
    }

    public function store(Request $request)
    {
        $data = $request->only('nama_kecamatan', 'kecamatan_existing');

        $nama = trim((string) ($data['nama_kecamatan'] ?? ''));
        $existing = trim((string) ($data['kecamatan_existing'] ?? ''));

        if ($nama === '' && $existing !== '') {
            $nama = $existing;
        }

        if ($nama === '') {
            return back()->withErrors(['nama_kecamatan' => 'Nama kecamatan wajib diisi.'])->withInput();
        }

        $kecamatan = Kecamatan::firstOrCreate(['nama_kecamatan' => $nama]);

        return redirect()->route('kecamatan.index')->with('status', 'Kecamatan berhasil ditambahkan.');
    }

    public function edit(Kecamatan $kecamatan)
    {
        return view('master.kecamatan.form', compact('kecamatan'));
    }

    public function update(Request $request, Kecamatan $kecamatan)
    {
        $nama = trim((string) $request->input('nama_kecamatan', ''));
        $existing = trim((string) $request->input('kecamatan_existing', ''));

        if ($nama === '' && $existing !== '') {
            $nama = $existing;
        }

        if ($nama === '') {
            $nama = $kecamatan->nama_kecamatan;
        }

        $kecamatan->update(['nama_kecamatan' => $nama]);
        return redirect()->route('kecamatan.index')->with('status', 'Kecamatan berhasil diperbarui.');
    }

    public function destroy(Kecamatan $kecamatan)
    {
        $kecamatan->delete();
        return redirect()->route('kecamatan.index')->with('status', 'Kecamatan berhasil dihapus.');
    }
}
