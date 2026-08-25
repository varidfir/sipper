<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PermohonanApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Permohonan::with(['kecamatan', 'desa', 'jenisPelayanan', 'user'])->latest();

        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('nomor_permohonan', 'like', "%{$search}%")
                    ->orWhere('nama_pemohon', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('tanggal_permohonan', $request->input('date'));
        }

        if ($request->filled('month')) {
            $query->whereMonth('tanggal_permohonan', $request->input('month'));
        }

        if ($request->filled('year')) {
            $query->whereYear('tanggal_permohonan', $request->input('year'));
        }

        if ($request->filled('jenis_pelayanan_id')) {
            $query->where('jenis_pelayanan_id', $request->input('jenis_pelayanan_id'));
        }

        if ($request->filled('kecamatan_id')) {
            $query->where('kecamatan_id', $request->input('kecamatan_id'));
        }

        if ($request->filled('desa_id')) {
            $query->where('desa_id', $request->input('desa_id'));
        }

        return response()->json([
            'success' => true,
            'message' => 'Daftar permohonan berhasil diambil',
            'data' => $query->get()->map(function ($permohonan) {
                return [
                    'id' => $permohonan->id,
                    'nomor_permohonan' => $permohonan->nomor_permohonan,
                    'nama_pemohon' => $permohonan->nama_pemohon,
                    'tanggal_permohonan' => $permohonan->tanggal_permohonan?->format('Y-m-d'),
                    'jenis_pelayanan' => $permohonan->jenisPelayanan?->nama_pelayanan,
                    'kecamatan' => $permohonan->kecamatan?->nama_kecamatan,
                    'desa' => $permohonan->desa?->nama_desa,
                    'user' => $permohonan->user?->name,
                    'keterangan' => $permohonan->keterangan,
                ];
            }),
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate(array_merge(Permohonan::rules(), [
                'nomor_permohonan' => ['required', 'string', 'max:50', 'unique:permohonan,nomor_permohonan'],
            ]));
            $data['user_id'] = Auth::id();

            $permohonan = Permohonan::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Permohonan berhasil dibuat',
                'data' => $this->formatPermohonan($permohonan),
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function show(Permohonan $permohonan)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail permohonan berhasil diambil',
            'data' => $this->formatPermohonan($permohonan),
        ]);
    }

    public function update(Request $request, Permohonan $permohonan)
    {
        try {
            $data = $request->validate(array_merge(Permohonan::rules($permohonan->id), [
                'nomor_permohonan' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('permohonan', 'nomor_permohonan')->ignore($permohonan->id),
                ],
            ]));
            $data['user_id'] = Auth::id();

            $permohonan->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Permohonan berhasil diperbarui',
                'data' => $this->formatPermohonan($permohonan),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function destroy(Permohonan $permohonan)
    {
        $permohonan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Permohonan berhasil dihapus',
        ]);
    }

    protected function formatPermohonan(Permohonan $permohonan): array
    {
        $permohonan->load(['kecamatan', 'desa', 'jenisPelayanan', 'user']);

        return [
            'id' => $permohonan->id,
            'nomor_permohonan' => $permohonan->nomor_permohonan,
            'nama_pemohon' => $permohonan->nama_pemohon,
            'tanggal_permohonan' => $permohonan->tanggal_permohonan?->format('Y-m-d'),
            'jenis_pelayanan' => $permohonan->jenisPelayanan?->nama_pelayanan,
            'kecamatan' => $permohonan->kecamatan?->nama_kecamatan,
            'desa' => $permohonan->desa?->nama_desa,
            'user' => $permohonan->user?->name,
            'keterangan' => $permohonan->keterangan,
        ];
    }
}
