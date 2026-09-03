<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($permohonan) ? 'Edit Rekap' : 'Input Rekap' }} - SIPPER</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .autocomplete { position: relative; }
        .autocomplete-control { position: relative; }
        .autocomplete-control .autocomplete-input { padding-right: 42px; }
        .autocomplete-toggle { position: absolute; top: 1px; right: 1px; bottom: 1px; width: 36px; border: 0; border-left: 1px solid #cbd5e1; border-radius: 0 2px 2px 0; background: #fff; color: #334155; cursor: pointer; font-size: 0; }
        .autocomplete-toggle::after { content: ''; display: block; width: 7px; height: 7px; margin: 0 auto; border-right: 1.5px solid currentColor; border-bottom: 1.5px solid currentColor; transform: rotate(45deg) translate(-2px, -2px); transition: transform .15s ease; }
        .autocomplete-toggle[aria-expanded="true"]::after { transform: rotate(225deg) translate(-2px, -2px); }
        .autocomplete-toggle:hover { background: #eff6ff; color: #1d61e8; }
        .autocomplete-menu { position: absolute; z-index: 20; top: calc(100% + 5px); left: 0; right: 0; max-height: 250px; overflow-y: auto; border: 1px solid #cbd5e1; border-radius: 2px; background: #fff; box-shadow: 0 10px 20px rgba(15, 23, 42, .16); }
        .autocomplete-menu[hidden] { display: none; }
        .autocomplete-option { display: block; width: 100%; min-height: 30px; padding: 4px 7px; border: 1px solid transparent; border-radius: 2px; background: #fff; color: #334155; text-align: left; font-size: 12px; cursor: pointer; }
        .autocomplete-option[hidden] { display: none; }
        .autocomplete-option:hover, .autocomplete-option.is-active { background: #eff6ff; color: #1d4ed8; }

        #success-notification {
            position: fixed;
            z-index: 100;
            top: 50%;
            left: 50%;
            width: min(320px, calc(100vw - 32px));
            margin: 0;
            padding: 12px 18px;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            background: #f0fdf4;
            box-shadow: 0 12px 30px rgba(15, 23, 42, .16);
            text-align: center;
            transform: translate(-50%, -50%) scale(.96);
            animation: notification-in .35s cubic-bezier(.22, 1, .36, 1) forwards;
        }

        #success-notification.is-hiding {
            animation: notification-out .35s ease forwards;
        }

        @keyframes notification-in {
            from { opacity: 0; transform: translate(-50%, -50%) scale(.96); }
            to { opacity: 1; transform: translate(-50%, -50%) scale(1); }
        }

        @keyframes notification-out {
            from { opacity: 1; transform: translate(-50%, -50%) scale(1); }
            to { opacity: 0; transform: translate(-50%, -50%) scale(.98); }
        }

        @media (prefers-reduced-motion: reduce) {
            #success-notification { animation: none; }
        }
    </style>
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
    $selectedKecamatan = $kecamatans->firstWhere('id', (int) $selectedKecamatanId);
    $selectedDesa = $desas->firstWhere('id', (int) $selectedDesaId);
@endphp

<div class="form-header">
    <div class="form-title-group">
        <h1>{{ isset($permohonan) ? 'Edit Data Rekap' : 'REGISTRASI' }}</h1>
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

            @if(session('status'))
                <div id="success-notification" class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm font-bold text-green-700">
                    {{ session('status') }}
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
                        <div class="form-field-name md:col-span-2">
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

                        <div class="form-field-desa">
                            <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                Desa/Kelurahan <span class="text-red-500">*</span>
                            </label>
                            <div class="autocomplete" data-autocomplete data-filter-by="kecamatan_id">
                                <input type="hidden" name="desa_id" id="desa_id" value="{{ $selectedDesaId }}">
                                    <div class="autocomplete-control">
                                     <input type="text" id="desa_search" autocomplete="off" required
                                         value="{{ $selectedDesa?->nama_desa ?? '' }}"
                                         placeholder="Ketik atau pilih desa/kelurahan"
                                         class="autocomplete-input w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                     <button type="button" class="autocomplete-toggle" aria-label="Tampilkan pilihan desa" aria-expanded="false">&#9662;</button>
                                    </div>
                                <div class="autocomplete-menu" role="listbox" hidden>
                                    @foreach($desas as $desa)
                                        <button type="button" class="autocomplete-option" role="option"
                                                data-value="{{ $desa->id }}" data-kecamatan_id="{{ $desa->kecamatan_id }}">
                                            {{ $desa->nama_desa }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="form-field-kecamatan">
                            <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                Kecamatan <span class="text-red-500">*</span>
                            </label>
                            <div class="autocomplete" data-autocomplete>
                                <input type="hidden" name="kecamatan_id" id="kecamatan_id" value="{{ $selectedKecamatanId }}">
                                    <div class="autocomplete-control">
                                     <input type="text" id="kecamatan_search" autocomplete="off" required
                                         value="{{ $selectedKecamatan?->nama_kecamatan ?? '' }}"
                                         placeholder="Ketik atau pilih kecamatan"
                                         class="autocomplete-input w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                     <button type="button" class="autocomplete-toggle" aria-label="Tampilkan pilihan kecamatan" aria-expanded="false">&#9662;</button>
                                    </div>
                                <div class="autocomplete-menu" role="listbox" hidden>
                                    @foreach($kecamatans as $kecamatan)
                                        <button type="button" class="autocomplete-option" role="option" data-value="{{ $kecamatan->id }}">
                                            {{ $kecamatan->nama_kecamatan }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="form-field-date">
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
                                <div class="form-field-jenis">
                                    <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                        Jenis KK <span class="text-red-500">*</span>
                                    </label>
                                    <div class="autocomplete service-autocomplete" data-autocomplete>
                                        <input type="hidden" name="jenis_pelayanan_id" class="jenis-select" value="{{ $selectedJenisId }}" disabled>
                                             <div class="autocomplete-control">
                                              <input type="text" autocomplete="off" required disabled
                                                  value="{{ $selectedJenis?->nama_pelayanan ?? '' }}"
                                                  placeholder="Ketik atau pilih jenis KK"
                                                  class="autocomplete-input w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5">
                                              <button type="button" class="autocomplete-toggle" aria-label="Tampilkan pilihan jenis KK" aria-expanded="false">&#9662;</button>
                                             </div>
                                        <div class="autocomplete-menu" role="listbox" hidden>
                                            @foreach($group->jenisPelayanans as $jenis)
                                                <button type="button" class="autocomplete-option" role="option" data-value="{{ $jenis->id }}">{{ $jenis->nama_pelayanan }}</button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field-keterangan">
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
                                <div class="form-field-jenis">
                                    <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                        Jenis Akta <span class="text-red-500">*</span>
                                    </label>
                                    <div class="autocomplete service-autocomplete" data-autocomplete>
                                        <input type="hidden" name="jenis_pelayanan_id" class="jenis-select" value="{{ $selectedJenisId }}" disabled>
                                             <div class="autocomplete-control">
                                              <input type="text" autocomplete="off" required disabled
                                                  value="{{ $selectedJenis?->nama_pelayanan ?? '' }}"
                                                  placeholder="Ketik atau pilih jenis akta"
                                                  class="autocomplete-input w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5">
                                              <button type="button" class="autocomplete-toggle" aria-label="Tampilkan pilihan jenis akta" aria-expanded="false">&#9662;</button>
                                             </div>
                                        <div class="autocomplete-menu" role="listbox" hidden>
                                            @foreach($group->jenisPelayanans as $jenis)
                                                <button type="button" class="autocomplete-option" role="option" data-value="{{ $jenis->id }}">{{ $jenis->nama_pelayanan }}</button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field-keterangan">
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
                                <div class="form-field-jenis">
                                    <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                        Jenis KTP <span class="text-red-500">*</span>
                                    </label>
                                    <div class="autocomplete service-autocomplete" data-autocomplete>
                                        <input type="hidden" name="jenis_pelayanan_id" class="jenis-select" value="{{ $selectedJenisId }}" disabled>
                                             <div class="autocomplete-control">
                                              <input type="text" autocomplete="off" required disabled
                                                  value="{{ $selectedJenis?->nama_pelayanan ?? '' }}"
                                                  placeholder="Ketik atau pilih jenis KTP"
                                                  class="autocomplete-input w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5">
                                              <button type="button" class="autocomplete-toggle" aria-label="Tampilkan pilihan jenis KTP" aria-expanded="false">&#9662;</button>
                                             </div>
                                        <div class="autocomplete-menu" role="listbox" hidden>
                                            @foreach($group->jenisPelayanans as $jenis)
                                                <button type="button" class="autocomplete-option" role="option" data-value="{{ $jenis->id }}">{{ $jenis->nama_pelayanan }}</button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field-keterangan">
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
                            @endif

                            {{-- SURAT PINDAH --}}
                            @if($code === 'SURAT_PINDAH')
                                <input type="hidden"
                                       name="jenis_pelayanan_id"
                                       class="jenis-select"
                                       value="{{ $group->jenisPelayanans->first()?->id }}"
                                       disabled>
                                <div class="form-field-keterangan form-field-surat-pindah">
                                    <label class="mb-1.5 block text-sm font-bold text-slate-700">
                                        Keterangan Pemohon <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           name="detail_data[keterangan]"
                                           value="{{ $detail['keterangan'] ?? '' }}"
                                           class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5"
                                           placeholder="Contoh: Kepala keluarga atau anggota keluarga">
                                </div>
                            @endif

                            {{-- PEREKAMAN --}}
                            @if($code === 'PEREKAMAN')
                                <input type="hidden"
                                       name="jenis_pelayanan_id"
                                       class="jenis-select"
                                       value="{{ $group->jenisPelayanans->first()?->id }}"
                                       disabled>
                                <div class="form-field-keterangan form-field-perekaman">
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
const successNotification = document.getElementById('success-notification');
if (successNotification) {
    window.setTimeout(() => successNotification.classList.add('is-hiding'), 3600);
    window.setTimeout(() => successNotification.remove(), 4000);
}

document.addEventListener('DOMContentLoaded', () => {
    const tabs = [...document.querySelectorAll('.category-tab')];
    const panels = [...document.querySelectorAll('.form-panel')];
    const empty = document.getElementById('empty-form');
    const selectedGroup = document.getElementById('selected_group');
    const description = document.getElementById('form-description');
    const kecamatan = document.getElementById('kecamatan_id');
    const desa = document.getElementById('desa_id');

    function setupAutocomplete(container) {
        const input = container.querySelector('.autocomplete-input');
        const hidden = container.querySelector('input[type="hidden"]');
        const menu = container.querySelector('.autocomplete-menu');
        const toggle = container.querySelector('.autocomplete-toggle');
        const options = [...container.querySelectorAll('.autocomplete-option')];
        let visibleOptions = [];
        let activeIndex = -1;

        function render(openMenu = false) {
            const query = input.value.trim().toLowerCase();
            const filterBy = container.dataset.filterBy;
            const filterValue = filterBy ? document.getElementById(filterBy)?.value : '';

            visibleOptions = options.filter(option => {
                const matchesText = option.textContent.trim().toLowerCase().includes(query);
                const matchesFilter = !filterBy || option.dataset[filterBy] === filterValue;
                option.hidden = !matchesText || !matchesFilter;
                option.classList.remove('is-active');
                return !option.hidden;
            });

            activeIndex = visibleOptions.length ? 0 : -1;
            if (visibleOptions[0]) visibleOptions[0].classList.add('is-active');
            menu.hidden = !openMenu || !visibleOptions.length;
            toggle?.setAttribute('aria-expanded', String(!menu.hidden));
        }

        function choose(option) {
            input.value = option.textContent.trim();
            hidden.value = option.dataset.value;
            menu.hidden = true;
            toggle?.setAttribute('aria-expanded', 'false');
            input.setCustomValidity('');
            input.dispatchEvent(new Event('change', { bubbles: true }));
        }

        input.addEventListener('focus', () => render(false));
        input.addEventListener('input', () => {
            hidden.value = '';
            input.setCustomValidity('');
            render(true);
        });
        input.addEventListener('keydown', event => {
            if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
                event.preventDefault();
                if (menu.hidden) return;
                if (!visibleOptions.length) return;
                activeIndex = (activeIndex + (event.key === 'ArrowDown' ? 1 : -1) + visibleOptions.length) % visibleOptions.length;
                visibleOptions.forEach(option => option.classList.remove('is-active'));
                visibleOptions[activeIndex].classList.add('is-active');
                visibleOptions[activeIndex].scrollIntoView({ block: 'nearest' });
            }

            if (event.key === 'Enter' && !menu.hidden && visibleOptions[activeIndex]) {
                event.preventDefault();
                choose(visibleOptions[activeIndex]);
            }

            if (event.key === 'Escape') {
                menu.hidden = true;
                toggle?.setAttribute('aria-expanded', 'false');
            }
        });
        toggle?.addEventListener('mousedown', event => event.preventDefault());
        toggle?.addEventListener('click', () => {
            if (menu.hidden) {
                input.focus();
                render(true);
            } else {
                menu.hidden = true;
                toggle.setAttribute('aria-expanded', 'false');
            }
        });
        options.forEach(option => option.addEventListener('mousedown', event => {
            event.preventDefault();
            choose(option);
        }));
        input.addEventListener('blur', () => window.setTimeout(() => {
            menu.hidden = true;
            toggle?.setAttribute('aria-expanded', 'false');
            if (container.classList.contains('service-autocomplete') && !hidden.value) {
                input.value = '';
            }
        }, 120));

        return { render };
    }

    const autocompleteInstances = [...document.querySelectorAll('[data-autocomplete]')]
        .map(container => ({ container, instance: setupAutocomplete(container) }));
    const desaAutocomplete = autocompleteInstances.find(item => item.container.dataset.filterBy === 'kecamatan_id')?.instance;

    function filterDesa() {
        const selectedOption = document.querySelector('#desa_search')?.value;
        desaAutocomplete?.render();
        const desaOption = document.querySelector(`#desa_search`)?.closest('[data-autocomplete]')?.querySelector(`.autocomplete-option[data-value="${desa.value}"]`);
        if (desa.value && (!desaOption || desaOption.dataset.kecamatan_id !== kecamatan.value)) {
            desa.value = '';
            document.getElementById('desa_search').value = '';
        } else if (selectedOption) {
            desaAutocomplete?.render();
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

            panel.querySelectorAll('input, select, textarea').forEach(input => {
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

    function focusCategory(index) {
        if (!tabs.length) return;

        const nextIndex = (index + tabs.length) % tabs.length;
        tabs[nextIndex].focus();
        activate(tabs[nextIndex].dataset.group);
    }

    tabs.forEach((tab, index) => {
        tab.addEventListener('keydown', event => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                activate(tab.dataset.group);
            }

            if (event.key === 'ArrowDown' || event.key === 'ArrowRight') {
                event.preventDefault();
                focusCategory(index + 1);
            }

            if (event.key === 'ArrowUp' || event.key === 'ArrowLeft') {
                event.preventDefault();
                focusCategory(index - 1);
            }
        });
    });

    const form = document.querySelector('.form-content');
    form.addEventListener('submit', event => {
        const invalidService = [...form.querySelectorAll('.service-autocomplete')]
            .map(container => ({
                input: container.querySelector('.autocomplete-input'),
                hidden: container.querySelector('input[type="hidden"]'),
            }))
            .find(field => !field.input.disabled && !field.hidden.value);

        if (invalidService) {
            event.preventDefault();
            invalidService.input.setCustomValidity('Pilih jenis pelayanan dari opsi yang tersedia.');
            invalidService.input.reportValidity();
            invalidService.input.focus();
        }
    });
    form.addEventListener('keydown', event => {
        if (event.target.closest('[data-autocomplete]')) return;
        if (event.key !== 'Enter' || event.target.matches('textarea, button, a')) return;

        event.preventDefault();
        const fields = [...form.querySelectorAll('input:not([type="hidden"]):not([disabled]), select:not([disabled]), textarea:not([disabled])')]
            .filter(field => field.offsetParent !== null);
        const currentIndex = fields.indexOf(event.target);
        const nextField = fields[currentIndex + 1];

        if (nextField) {
            nextField.focus();
        } else {
            form.querySelector('button[type="submit"]')?.focus();
        }
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
