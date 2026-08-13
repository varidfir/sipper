@include('layouts.sidebar')

<main class="sipper-content">
    <div class="min-h-screen bg-slate-100 p-4 sm:p-6 lg:p-8">
        <div class="mx-auto max-w-5xl">
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.12em] text-blue-600">Administrasi</p>
                        <h1 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">Data Kecamatan</h1>
                    </div>
                    <a href="{{ route('kecamatan.create') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                        + Tambah Kecamatan
                    </a>
                </div>

                @if(session('status'))
                    <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200">
                    <div class="flex items-center justify-between border-b border-slate-200 bg-slate-50 px-5 py-4">
                        <h2 class="text-base font-bold text-slate-900">Daftar Kecamatan</h2>
                        <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">
                            {{ $kecamatans->count() }} data
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">Nama Kecamatan</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($kecamatans as $kecamatan)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-4 py-3 font-medium text-slate-600">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">
                                            <div class="font-semibold text-slate-800">{{ $kecamatan->nama_kecamatan }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('kecamatan.edit', $kecamatan) }}" class="rounded-lg border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 transition hover:bg-blue-100">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('kecamatan.destroy', $kecamatan) }}" onsubmit="return confirm('Hapus data kecamatan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-100">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-12 text-center text-sm text-slate-500">
                                            Belum ada data kecamatan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
