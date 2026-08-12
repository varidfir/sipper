<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendataan Permohonan - SIPPER</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
@include('layouts.sidebar')
<main class="sipper-content">
<div class="min-h-screen p-4 sm:p-6 lg:p-8">
    <div class="mx-auto max-w-7xl">
        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm font-semibold text-blue-600">SIPPER • Pendataan</p>
                    <h1 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">Data Permohonan</h1>
                    <p class="mt-1 text-sm text-slate-500">Cari, filter, lihat, edit, dan hapus data permohonan.</p>
                </div>
                <a href="{{ route('permohonan.create') }}" class="rounded-xl bg-blue-600 px-4 py-2.5 text-center text-sm font-bold text-white hover:bg-blue-700">+ Tambah Permohonan</a>
            </div>

            @if(session('status'))
                <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">{{ session('status') }}</div>
            @endif

            <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200">
                <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                    <h2 class="font-bold text-slate-900">Pencarian & Filter</h2>
                </div>
                <form method="GET" action="{{ route('permohonan.index') }}" class="grid gap-4 p-5 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="sm:col-span-2">
                        <label class="mb-1 block text-sm font-semibold">Pencarian</label>
                        <input name="search" value="{{ request('search') }}" placeholder="Nomor, nama, keterangan"
                               class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Tanggal</label>
                        <input type="date" name="date" value="{{ request('date') }}"
                               class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Tahun</label>
                        <input type="number" name="year" min="2000" max="2100" value="{{ request('year') }}"
                               class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Bulan</label>
                        <select name="month" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-blue-500 focus:outline-none">
                            <option value="">Semua Bulan</option>
                            @foreach(range(1,12) as $month)
                                <option value="{{ $month }}" {{ (string)request('month') === (string)$month ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Kategori</label>
                        <select name="kelompok_pelayanan_id" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-blue-500 focus:outline-none">
                            <option value="">Semua Kategori</option>
                            @foreach($kelompokPelayanans as $group)
                                <option value="{{ $group->id }}" {{ request('kelompok_pelayanan_id') == $group->id ? 'selected' : '' }}>{{ $group->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Jenis Pelayanan</label>
                        <select name="jenis_pelayanan_id" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-blue-500 focus:outline-none">
                            <option value="">Semua Jenis</option>
                            @foreach($kelompokPelayanans as $group)
                                <optgroup label="{{ $group->nama }}">
                                    @foreach($group->jenisPelayanans as $jenis)
                                        <option value="{{ $jenis->id }}" {{ request('jenis_pelayanan_id') == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama_pelayanan }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Kecamatan</label>
                        <select name="kecamatan_id" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-blue-500 focus:outline-none">
                            <option value="">Semua Kecamatan</option>
                            @foreach($kecamatans as $kecamatan)
                                <option value="{{ $kecamatan->id }}" {{ request('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold">Desa/Kelurahan</label>
                        <select name="desa_id" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-blue-500 focus:outline-none">
                            <option value="">Semua Desa/Kelurahan</option>
                            @foreach($desas as $desa)
                                <option value="{{ $desa->id }}" {{ request('desa_id') == $desa->id ? 'selected' : '' }}>{{ $desa->nama_desa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2 sm:col-span-2 lg:col-span-4">
                        <button class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-bold text-white hover:bg-slate-700">Terapkan Filter</button>
                        <a href="{{ route('permohonan.index') }}" class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-bold hover:bg-slate-50">Reset</a>
                    </div>
                </form>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-slate-900">Daftar Data</h2>
                    <p class="text-sm text-slate-500">{{ $permohonans->count() }} data ditemukan.</p>
                </div>
            </div>

            <div class="mt-4 overflow-x-auto rounded-2xl border border-slate-200">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Jenis</th>
                            <th class="px-4 py-3">Kecamatan</th>
                            <th class="px-4 py-3">Desa</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                    @forelse($permohonans as $i => $permohonan)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">{{ $i + 1 }}</td>
                            <td class="whitespace-nowrap px-4 py-3">{{ $permohonan->tanggal_permohonan?->format('d/m/Y') ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="font-semibold text-slate-900">{{ $permohonan->nama_pemohon }}</div>
                                <div class="text-xs text-slate-500">{{ $permohonan->nomor_permohonan }}</div>
                            </td>
                            <td class="px-4 py-3">{{ $permohonan->jenisPelayanan?->kelompokPelayanan?->kode ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $permohonan->jenisPelayanan?->nama_pelayanan ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $permohonan->kecamatan?->nama_kecamatan ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $permohonan->desa?->nama_desa ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('permohonan.show', $permohonan) }}" class="rounded-lg border px-3 py-1.5 text-xs font-semibold hover:bg-slate-50">Detail</a>
                                    <a href="{{ route('permohonan.edit', $permohonan) }}" class="rounded-lg border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-100">Edit</a>
                                    <form method="POST" action="{{ route('permohonan.destroy', $permohonan) }}" onsubmit="return confirm('Hapus data permohonan ini?')">
                                        @csrf @method('DELETE')
                                        <button class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-100">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-4 py-12 text-center text-slate-500">Belum ada data permohonan.</td></tr>
                    @endforelse
                    </tbody>
                </t</main>
able>
            </div>
        </div>
    </div>
</div>
</body>
</html>
