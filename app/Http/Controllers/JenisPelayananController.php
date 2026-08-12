<?php

namespace App\Http\Controllers;

use App\Models\JenisPelayanan;
use Illuminate\Http\Request;

class JenisPelayananController extends Controller
{
    public function index()
    {
        $jenisPelayanans = JenisPelayanan::latest()->get();
        return view('master.jenis-pelayanan.index', compact('jenisPelayanans'));
    }

    public function create()
    {
        return view('master.jenis-pelayanan.form');
    }

    public function store(Request $request)
    {
        $request->validate(JenisPelayanan::rules());
        JenisPelayanan::create($request->only('nama_pelayanan', 'kategori'));
        return redirect()->route('jenis-pelayanan.index')->with('status', 'Jenis pelayanan berhasil ditambahkan.');
    }

    public function edit(JenisPelayanan $jenisPelayanan)
    {
        return view('master.jenis-pelayanan.form', compact('jenisPelayanan'));
    }

    public function update(Request $request, JenisPelayanan $jenisPelayanan)
    {
        $request->validate(JenisPelayanan::rules());
        $jenisPelayanan->update($request->only('nama_pelayanan', 'kategori'));
        return redirect()->route('jenis-pelayanan.index')->with('status', 'Jenis pelayanan berhasil diperbarui.');
    }

    public function destroy(JenisPelayanan $jenisPelayanan)
    {
        $jenisPelayanan->delete();
        return redirect()->route('jenis-pelayanan.index')->with('status', 'Jenis pelayanan berhasil dihapus.');
    }
}
