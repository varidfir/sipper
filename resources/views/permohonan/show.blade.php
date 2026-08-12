<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Permohonan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
@include('layouts.sidebar')
<main class="sipper-content">
    <div class="min-h-screen bg-slate-100 p-6 lg:p-8">
        <div class="mx-auto max-w-4xl rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600">Detail Permohonan</p>
                    <h1 class="mt-1 text-3xl font-bold text-slate-900">{{ $permohonan->nomor_permohonan }}</h1>
                </div>
                <a href="{{ route('permohonan.index') }}" class="inline-flex items-center rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">← Kembali</a>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                    <h2 class="text-lg font-semibold text-slate-900">Data Utama</h2>
                    <div class="mt-4 space-y-3 text-sm text-slate-600">
                        <p><span class="font-semibold text-slate-800">Nama Pemohon:</span> {{ $permohonan->nama_pemohon }}</p>
                        <p><span class="font-semibold text-slate-800">Tanggal:</span> {{ $permohonan->tanggal_permohonan?->format('d-m-Y') }}</p>
                        <p><span class="font-semibold text-slate-800">Jenis Pelayanan:</span> {{ $permohonan->jenisPelayanan->nama_pelayanan ?? '-' }}</p>
                        <p><span class="font-semibold text-slate-800">Kecamatan:</span> {{ $permohonan->kecamatan->nama_kecamatan ?? '-' }}</p>
                        <p><span class="font-semibold text-slate-800">Desa:</span> {{ $permohonan->desa->nama_desa ?? '-' }}</p>
                        <p><span class="font-semibold text-slate-800">Petugas Input:</span> {{ $permohonan->user->name ?? '-' }}</p>
                        <p><span class="font-semibold text-slate-800">Keterangan:</span> {{ $permohonan->keterangan ?? '-' }}</p>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                    <h2 class="text-lg font-semibold text-slate-900">Detail Khusus</h2>
                    <div class="mt-4 space-y-3 text-sm text-slate-600">
                        @forelse($permohonan->detail_data ?? [] as $key => $value)
                            <p><span class="font-semibold text-slate-800">{{ ucwords(str_replace('_', ' ', $key)) }}:</span> {{ $value }}</p>
                        @empty
                            <p>Tidak ada detail khusus untuk permohonan ini.</p>
                        @endforelse
                    </div>
          </main>
      </div>
            </div>
        </div>
    </div>
</body>
</html>
