@include('layouts.sidebar')

<main class="sipper-content">
    <div class="min-h-screen bg-slate-100 px-3 py-3 sm:px-4 sm:py-4 lg:px-5 lg:py-5">
        <div class="w-full">

            <div class="mb-6">
                <p class="text-[10px] font-black uppercase tracking-[0.18em] text-blue-600 sm:text-xs">
                    ADMINISTRASI
                </p>

                <h1 class="mt-2 text-4xl font-black leading-none tracking-[-0.04em] text-slate-900 sm:text-5xl">
                    Data Kecamatan
                </h1>

                <p class="mt-3 text-base text-slate-500">
                    Kelola data kecamatan dalam wilayah kerja.
                </p>

                <div class="mt-5 flex flex-wrap items-center gap-3 text-lg font-medium text-violet-700">
                    <a href="{{ route('kecamatan.create') }}" class="inline-flex items-center gap-2 hover:text-violet-800">
                        <span class="text-xl">+Tambah</span>
                    </a>
                    <span class="text-violet-700">←</span>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 hover:text-violet-800">
                        <span>Kembali</span>
                    </a>
                </div>
            </div>

            @if(session('status'))
                <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mt-4">
                <h2 class="text-4xl font-black leading-none tracking-[-0.04em] text-slate-900">
                    Daftar Kecamatan
                </h2>

                <p class="mt-3 text-lg text-slate-500">
                    {{ $kecamatans->count() }} kecamatan terdaftar
                </p>
            </div>

            <div class="mt-6 space-y-4">
                @forelse($kecamatans as $kecamatan)
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div class="min-w-0 flex-1">
                            <p class="text-[18px] font-bold uppercase tracking-tight text-slate-900 sm:text-[22px]">
                                {{ strtoupper($kecamatan->nama_kecamatan) }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2 text-sm sm:text-base">
                            <a href="{{ route('kecamatan.edit', $kecamatan) }}" class="text-blue-600 hover:text-blue-700">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('kecamatan.destroy', $kecamatan) }}" onsubmit="return confirm('Hapus data ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-md border border-slate-300 bg-slate-100 px-2 py-1 text-slate-600 hover:bg-slate-200 hover:text-slate-800">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="py-8 text-center text-lg text-slate-500">Belum ada data kecamatan</p>
                @endforelse
            </div>
        </div>
    </div>
</main>
