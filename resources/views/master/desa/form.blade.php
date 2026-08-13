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
                            {{ isset($desa) ? 'Edit Desa' : 'Tambah Desa' }}
                        </h1>
                        <p class="mt-1 text-xs text-slate-500 sm:text-sm">
                            {{ isset($desa) ? 'Perbarui data desa yang sudah ada' : 'Tambahkan desa/kelurahan baru ke sistem' }}
                        </p>
                    </div>
                    <a href="{{ route('desa.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-center text-sm font-bold transition hover:bg-slate-50">
                        ← Kembali
                    </a>
                </div>
            </div>

            {{-- ERROR --}}
            @if($errors->any())
                <div class="mx-5 mt-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 sm:mx-6">
                    <p class="font-bold">Terjadi kesalahan:</p>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM --}}
            <div class="p-5 sm:p-6">
                <form method="POST" action="{{ isset($desa) ? route('desa.update', $desa) : route('desa.store') }}">
                    @csrf
                    @if(isset($desa)) @method('PUT') @endif

                    <section class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:p-5">
                        <div class="border-b border-slate-200 pb-3">
                            <h2 class="font-bold text-slate-900">
                                {{ isset($desa) ? 'Data Desa' : 'Data Desa Baru' }}
                            </h2>
                        </div>

                        <div class="mt-4 space-y-4">
                            {{-- Pilih Kecamatan --}}
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-800">
                                    Pilih Kecamatan <span class="text-red-500">*</span>
                                </label>
                                <select name="kecamatan_id" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                    <option value="">-- Pilih atau Tulis Manual --</option>
                                    @foreach($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $desa->kecamatan_id ?? '') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Kecamatan Manual --}}
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-800">
                                    Atau Ketik Nama Kecamatan Baru
                                </label>
                                <input type="text" name="kecamatan_manual" value="{{ old('kecamatan_manual') }}" placeholder="Jika ingin membuat kecamatan baru" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 shadow-sm placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            </div>

                            {{-- Nama Desa --}}
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-800">
                                    Nama Desa/Kelurahan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_desa" value="{{ old('nama_desa', $desa->nama_desa ?? '') }}" placeholder="Ketik nama desa/kelurahan" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 shadow-sm placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" required>
                            </div>
                        </div>

                        {{-- TOMBOL --}}
                        <div class="mt-6 flex flex-wrap gap-3 border-t border-slate-200 pt-4">
                            <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700">
                                {{ isset($desa) ? 'Perbarui' : 'Tambah' }} Desa
                            </button>
                            <a href="{{ route('desa.index') }}" class="rounded-xl border border-slate-300 bg-white px-6 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-50">
                                Batal
                            </a>
                        </div>
                    </section>
                </form>
            </div>

        </div>
    </div>
</main>
