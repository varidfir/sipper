<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\JenisPelayanan;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class MasterDataApiController extends Controller
{
    public function kecamatan()
    {
        $data = Kecamatan::orderBy('nama_kecamatan')->get(['id', 'nama_kecamatan']);

        return response()->json([
            'success' => true,
            'message' => 'Data kecamatan berhasil diambil',
            'data' => $data,
        ]);
    }

    public function desa(Request $request)
    {
        $query = Desa::query()->with('kecamatan')->orderBy('nama_desa');

        if ($request->filled('kecamatan_id')) {
            $query->where('kecamatan_id', $request->input('kecamatan_id'));
        }

        $data = $query->get(['id', 'kecamatan_id', 'nama_desa']);

        return response()->json([
            'success' => true,
            'message' => 'Data desa berhasil diambil',
            'data' => $data,
        ]);
    }

    public function jenisPelayanan()
    {
        $data = JenisPelayanan::orderBy('nama_pelayanan')->get(['id', 'nama_pelayanan', 'kategori']);

        return response()->json([
            'success' => true,
            'message' => 'Data jenis pelayanan berhasil diambil',
            'data' => $data,
        ]);
    }
}
