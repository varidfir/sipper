@include('layouts.sidebar')

<main class="sipper-content">
    <div class="min-h-screen bg-slate-100 p-4 sm:p-6 lg:p-8">
        <div class="mx-auto max-w-2xl">
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                <div class="mb-6">
                    <p class="text-sm font-semibold uppercase tracking-[0.12em] text-blue-600">Administrasi</p>
                    <h1 class="mt-1 text-2xl font-bold text-slate-900">
                        {{ isset($kecamatan) ? 'Edit Kecamatan' : 'Tambah Kecamatan' }}
                    </h1>
                </div>

                @if($errors->any())
                    <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ isset($kecamatan) ? route('kecamatan.update', $kecamatan) : route('kecamatan.store') }}" class="space-y-5">
                    @csrf
                    @if(isset($kecamatan)) @method('PUT') @endif

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Pilih kecamatan yang sudah ada</label>
                        <select name="kecamatan_existing" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <option value="">-- Pilih / tulis manual --</option>
                            @foreach(App\Models\Kecamatan::orderBy('nama_kecamatan')->get() as $item)
                                <option value="{{ $item->nama_kecamatan }}" {{ old('kecamatan_existing') == $item->nama_kecamatan ? 'selected' : '' }}>{{ $item->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Atau tulis nama kecamatan baru</label>
                        <input type="text" name="nama_kecamatan" value="{{ old('nama_kecamatan', $kecamatan->nama_kecamatan ?? '') }}" placeholder="Ketik nama kecamatan jika tidak ada di daftar" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-700 shadow-sm placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                            Simpan
                        </button>
                        <a href="{{ route('kecamatan.index') }}" class="rounded-xl border border-slate-300 bg-slate-50 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
