@vite(['resources/css/app.css', 'resources/js/app.js'])
@include('layouts.sidebar')

<main class="sipper-content">
    <div class="min-h-screen px-3 py-3 sm:px-4 sm:py-4 lg:px-5 lg:py-5">
        <div class="w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- HEADER --}}
            <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-600">
                            ADMINISTRASI
                        </p>
                        <h1 class="mt-1 text-xl font-bold text-slate-900 sm:text-2xl">
                            Jenis Pelayanan
                        </h1>
                        <p class="mt-1 text-xs text-slate-500 sm:text-sm">
                            Kelola jenis-jenis pelayanan yang tersedia di sistem.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('jenis-pelayanan.create') }}" class="rounded-xl border border-blue-600 bg-blue-600 px-4 py-2 text-center text-sm font-bold text-white transition hover:bg-blue-700">
                            + Tambah
                        </a>
                        <a href="{{ route('dashboard') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-center text-sm font-bold transition hover:bg-slate-50">
                            ← Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- NOTIFIKASI --}}
            @if(session('status'))
                <div class="mx-5 mt-4 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700 sm:mx-6">
                    <p class="font-bold">✓ Berhasil</p>
                    <p class="mt-1">{{ session('status') }}</p>
                </div>
            @endif

            {{-- DAFTAR JENIS PELAYANAN --}}
            <div class="p-5 sm:p-6">
                <section class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:p-5">
                    <div class="border-b border-slate-200 pb-3">
                        <h2 class="font-bold text-slate-900">Daftar Jenis Pelayanan</h2>
                        <p class="mt-1 text-xs text-slate-500 sm:text-sm">{{ $jenisPelayanans->count() }} jenis pelayanan terdaftar</p>
                    </div>

                    <div class="mt-4">
                        @forelse($jenisPelayanans as $jenisPelayanan)
                            <div class="mb-3 flex flex-col gap-2 rounded-xl border border-slate-200 bg-white p-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex-1">
                                    <p class="font-semibold text-slate-900">{{ $jenisPelayanan->nama_pelayanan }}</p>
                                    <p class="mt-1 text-xs text-slate-500">
                                        <span class="rounded-full bg-slate-200 px-2 py-0.5">{{ $jenisPelayanan->kategori }}</span>
                                    </p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('jenis-pelayanan.edit', $jenisPelayanan) }}" class="rounded-lg border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 transition hover:bg-blue-100">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('jenis-pelayanan.destroy', $jenisPelayanan) }}" onsubmit="return confirm('Hapus data ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="py-8 text-center text-sm text-slate-500">Belum ada jenis pelayanan</p>
                        @endforelse
                    </div>
                </section>
            </div>

        </div>
    </div>
</main>
