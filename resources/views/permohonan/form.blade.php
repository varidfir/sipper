<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($permohonan) ? 'Edit Rekap' : 'Input Rekap' }} - SIPPER</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="app">
@include('layouts.sidebar')

<main class="sipper-content">
    @include('layouts.header', ['pageTitle' => isset($permohonan) ? 'Edit Rekap' : 'Input Rekap'])

    <div class="page-shell">
        <div class="form-page-container">
@php
    $selectedJenisId = old('jenis_pelayanan_id', $permohonan->jenis_pelayanan_id ?? null);
    $selectedJenis = $selectedJenisId
        ? $kelompokPelayanans->flatMap->jenisPelayanans->firstWhere('id', (int) $selectedJenisId)
        : null;

    $selectedGroupId = $selectedJenis?->kelompok_pelayanan_id;
    $detail = old('detail_data', $permohonan->detail_data ?? []);
    $selectedKecamatanId = old('kecamatan_id', $permohonan->kecamatan_id ?? '');
    $selectedDesaId = old('desa_id', $permohonan->desa_id ?? '');
@endphp

<div class="form-header">
    <div class="form-title-group">
        <h1>{{ isset($permohonan) ? 'Edit Data Rekap' : 'Input Rekap Baru' }}</h1>
        <p>Isi data sesuai jenis pelayanan yang dipilih.</p>
    </div>
    <a href="{{ route('permohonan.index') }}" class="btn-back">← Kembali</a>
</div>

        <form method="POST"
              action="{{ isset($permohonan) ? route('permohonan.update', $permohonan) : route('permohonan.store') }}"
              class="form-content">
            @csrf
            @if(isset($permohonan)) @method('PUT') @endif

            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <p class="font-bold">Data belum dapat disimpan.</p>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- KATEGORI UTAMA --}}
            <section>
                <div class="service-section-title">Pilih Jenis Pelayanan</div>

                <div class="service-grid">
                    @foreach($kelompokPelayanans as $group)
                        <button type="button"
                                data-group="{{ $group->id }}"
                                class="service-card category-tab">
                            <span class="service-card-label">{{ $group->kode === 'SURAT_PINDAH' ? 'SURAT PINDAH' : $group->kode }}</span>
                        </button>
                    @endforeach
                </div>
            </section>

            <input type="hidden" id="selected_group" value="{{ $selectedGroupId ?? '' }}">

            {{-- FORM --}}
            <section class="form-panel-card">
                <div class="panel-card-head">
                    <div>
                        <h2>Data Permohonan</h2>
                        <p id="form-description">Pilih kategori terlebih dahulu.</p>
                    </div>
                </div>

                <div id="empty-form" class="empty-form-message">
                    Silakan klik kategori pelayanan di atas.
                </div>

                <div class="base-fields">
                    <div class="field-grid">
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                Nama <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="nama_pemohon"
                                   value="{{ old('nama_pemohon', $permohonan->nama_pemohon ?? '') }}"
                                   required
                                   class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                   placeholder="Nama pemohon">
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                Desa/Kelurahan <span class="text-red-500">*</span>
                            </label>
                            <select name="desa_id"
                                    id="desa_id"
                                    required
                                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <option value="">Pilih Desa/Kelurahan</option>
                                @foreach($desas as $desa)
                                    <option value="{{ $desa->id }}"
                                            data-kecamatan="{{ $desa->kecamatan_id }}"
                                            {{ (string)$selectedDesaId === (string)$desa->id ? 'selected' : '' }}>
                                        {{ $desa->nama_desa }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                Kecamatan <span class="text-red-500">*</span>
                            </label>
                            <select name="kecamatan_id"
                                    id="kecamatan_id"
                                    required
                                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <option value="">Pilih Kecamatan</option>
                                @foreach($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->id }}" {{ (string)$selectedKecamatanId === (string)$kecamatan->id ? 'selected' : '' }}>
                                        {{ $kecamatan->nama_kecamatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                Tanggal <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                   name="tanggal_permohonan"
                                   value="{{ old('tanggal_permohonan', isset($permohonan) ? $permohonan->tanggal_permohonan?->format('Y-m-d') : now()->format('Y-m-d')) }}"
                                   required
                                   class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        </div>
                    </div>
                </div>

                @foreach($kelompokPelayanans as $group)
                    @php
                        $code = $group->kode;
                        $isActive = (string)$selectedGroupId === (string)$group->id;
                    @endphp

                    <div class="form-panel {{ $isActive ? '' : 'hidden' }}"
                         data-panel="{{ $group->id }}"
                         data-code="{{ $code }}">

                        <div class="grid gap-4 md:grid-cols-2">

                            {{-- KK --}}
                            @if($code === 'KK')
                                <div>
                                    <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                        Jenis KK <span class="text-red-500">*</span>
                                    </label>
                                    <select name="jenis_pelayanan_id" class="jenis-select w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5" required disabled>
                                        <option value="">Pilih jenis KK</option>
                                        @foreach($group->jenisPelayanans as $jenis)
                                            <option value="{{ $jenis->id }}" {{ (int)$selectedJenisId === (int)$jenis->id ? 'selected' : '' }}>
                                                {{ $jenis->nama_pelayanan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                        Keterangan (siapa pemohonnya) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           name="detail_data[keterangan]"
                                           value="{{ $detail['keterangan'] ?? '' }}"
                                           class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5"
                                           placeholder="Contoh: Kepala keluarga / anggota keluarga">
                                </div>
                            @endif

                            {{-- AKTA --}}
                            @if($code === 'AKTA')
                                <div>
                                    <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                        Jenis Akta <span class="text-red-500">*</span>
                                    </label>
                                    <select name="jenis_pelayanan_id" class="jenis-select w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5" required disabled>
                                        <option value="">Pilih jenis akta</option>
                                        @foreach($group->jenisPelayanans as $jenis)
                                            <option value="{{ $jenis->id }}" {{ (int)$selectedJenisId === (int)$jenis->id ? 'selected' : '' }}>
                                                {{ $jenis->nama_pelayanan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                        No. Kendali <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           name="detail_data[nomor_kendali]"
                                           value="{{ $detail['nomor_kendali'] ?? '' }}"
                                           class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5"
                                           placeholder="Nomor kendali">
                                </div>
                            @endif

                            {{-- KTP --}}
                            @if($code === 'KTP')
                                <div>
                                    <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                        Jenis KTP <span class="text-red-500">*</span>
                                    </label>
                                    <select name="jenis_pelayanan_id" class="jenis-select w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5" required disabled>
                                        <option value="">Pilih jenis KTP</option>
                                        @foreach($group->jenisPelayanans as $jenis)
                                            <option value="{{ $jenis->id }}" {{ (int)$selectedJenisId === (int)$jenis->id ? 'selected' : '' }}>
                                                {{ $jenis->nama_pelayanan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                        Keterangan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           name="detail_data[keterangan]"
                                           value="{{ $detail['keterangan'] ?? '' }}"
                                           class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5"
                                           placeholder="Contoh: Hilang / Rusak / Elemen / PRR">
                                </div>
                            @endif

                            {{-- KIA --}}
                            @if($code === 'KIA')
                                <input type="hidden"
                                       name="jenis_pelayanan_id"
                                       class="jenis-select"
                                       value="{{ $group->jenisPelayanans->first()?->id }}"
                                       disabled>
                                <div class="md:col-span-2 rounded-2xl bg-white p-4">
                                    <p class="text-sm font-bold text-slate-800">Pelayanan: KIA</p>
                                    <p class="mt-1 text-xs text-slate-500">Tidak ada data tambahan yang perlu diisi.</p>
                                </div>
                            @endif

                            {{-- SURAT PINDAH --}}
                            @if($code === 'SURAT_PINDAH')
                                <input type="hidden"
                                       name="jenis_pelayanan_id"
                                       class="jenis-select"
                                       value="{{ $group->jenisPelayanans->first()?->id }}"
                                       disabled>
                                <div class="md:col-span-2">
                                    <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                        Keterangan (siapa pemohonnya) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           name="detail_data[keterangan]"
                                           value="{{ $detail['keterangan'] ?? '' }}"
                                           class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5"
                                           placeholder="Contoh: Kepala keluarga / anggota keluarga">
                                </div>
                            @endif

                            {{-- PEREKAMAN --}}
                            @if($code === 'PEREKAMAN')
                                <input type="hidden"
                                       name="jenis_pelayanan_id"
                                       class="jenis-select"
                                       value="{{ $group->jenisPelayanans->first()?->id }}"
                                       disabled>
                                <div class="md:col-span-2">
                                    <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                        Keterangan (pemula) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           name="detail_data[keterangan]"
                                           value="{{ $detail['keterangan'] ?? '' }}"
                                           class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5"
                                           placeholder="Contoh: Pemula">
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </section>

            <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <a href="{{ route('permohonan.index') }}" class="rounded-xl border border-slate-300 px-5 py-2.5 text-center text-sm font-bold hover:bg-white">
                    Batal
                </a>
                <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white hover:bg-blue-700">
                    {{ isset($permohonan) ? 'Simpan Perubahan' : 'Simpan Data Rekap' }}
                </button>
            </div>
        </form>
    </div>
</div>
</main>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabs = [...document.querySelectorAll('.category-tab')];
    const panels = [...document.querySelectorAll('.form-panel')];
    const empty = document.getElementById('empty-form');
    const selectedGroup = document.getElementById('selected_group');
    const description = document.getElementById('form-description');
    const kecamatan = document.getElementById('kecamatan_id');
    const desa = document.getElementById('desa_id');

    function filterDesa() {
        const kecamatanId = kecamatan.value;

        [...desa.options].forEach(option => {
            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden = option.dataset.kecamatan !== kecamatanId;
        });

        if (desa.value && desa.selectedOptions[0]?.dataset.kecamatan !== kecamatanId) {
            desa.value = '';
        }
    }

    kecamatan.addEventListener('change', filterDesa);
    filterDesa();

    function activate(groupId) {
        const tab = tabs.find(item => item.dataset.group === String(groupId));

        tabs.forEach(item => {
            const active = item.dataset.group === String(groupId);
            item.classList.toggle('bg-blue-600', active);
            item.classList.toggle('text-white', active);
            item.classList.toggle('border-blue-600', active);
            item.classList.toggle('bg-white', !active);
            item.classList.toggle('text-slate-700', !active);
        });

        panels.forEach(panel => {
            const active = panel.dataset.panel === String(groupId);
            panel.classList.toggle('hidden', !active);

            panel.querySelectorAll('.jenis-select').forEach(input => {
                input.disabled = !active;
            });

            // Hanya field pada panel aktif yang wajib diisi.
            panel.querySelectorAll('input[required], select[required]').forEach(input => {
                input.required = active;
            });
        });

        const activePanel = panels.find(panel => panel.dataset.panel === String(groupId));

        empty.classList.toggle('hidden', !!activePanel);
        selectedGroup.value = groupId || '';

        if (tab) {
            description.textContent = `Form ${tab.textContent.trim()} aktif.`;
        }
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', () => activate(tab.dataset.group));
    });

    const initial = selectedGroup.value;
    if (initial) {
        activate(initial);
    } else if (tabs.length) {
        activate(tabs[0].dataset.group);
    }
});
</script>
</body>
</html>
