<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ isset($permohonan) ? 'Edit Rekap' : 'Input Rekap' }} - Berita Acara
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <div class="app">

        {{-- SIDEBAR --}}
        @include('layouts.sidebar')

        {{-- KONTEN UTAMA --}}
        <main class="sipper-content">
            @include('layouts.header', ['pageTitle' => isset($permohonan) ? 'Edit Rekap' : 'Input Rekap'])

            <div class="page-shell">

                <div class="form-page-container">

                    @php
                        $selectedJenisId = old(
                            'jenis_pelayanan_id',
                            $permohonan->jenis_pelayanan_id ?? null
                        );

                        $selectedJenis = $selectedJenisId
                            ? $kelompokPelayanans
                                ->flatMap->jenisPelayanans
                                ->firstWhere('id', (int) $selectedJenisId)
                            : null;

                        $selectedGroupId = $selectedJenis?->kelompok_pelayanan_id;

                        $detail = old(
                            'detail_data',
                            $permohonan->detail_data ?? []
                        );
                    @endphp

                    {{-- =====================================================
                        HEADER PAGE
                    ====================================================== --}}
                    <div class="form-header">
                        <div class="form-title-group">
                            <h1>{{ isset($permohonan) ? 'Edit Data Rekap' : 'Input Rekap Baru' }}</h1>
                            <p>Isi data sesuai jenis pelayanan yang dipilih.</p>
                        </div>
                    </div>


                    {{-- =====================================================
                        ERROR NOTIFICATION
                    ====================================================== --}}
                    @if($errors->any())
                        <div style="background:#fef2f2; border:1px solid #fecaca; color:#b91c1c; padding:14px 18px; border-radius:12px; margin-bottom:20px; font-size:13px;">
                            <p style="font-weight:700; margin:0 0 6px;">Data belum dapat disimpan.</p>
                            <ul style="margin:0; padding-left:18px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    {{-- =====================================================
                        FORM UTAMA
                    ====================================================== --}}
                    <form
                        method="POST"
                        action="{{ isset($permohonan)
                            ? route('permohonan.update', $permohonan)
                            : route('permohonan.store') }}"
                    >
                        @csrf
                        @if(isset($permohonan))
                            @method('PUT')
                        @endif

                        {{-- GROUP AKTIF --}}
                        <input
                            type="hidden"
                            id="selected_group"
                            value="{{ $selectedGroupId }}"
                        >


                        {{-- =====================================================
                            PILIK JENIS PELAYANAN (6 CARDS GRID)
                        ====================================================== --}}
                        <div class="service-section-title">Pilih Jenis Pelayanan</div>
                        <div class="service-grid">
                            @foreach($kelompokPelayanans as $group)
                                <button
                                    type="button"
                                    class="service-card service-tab {{ $selectedGroupId == $group->id ? 'is-active' : '' }}"
                                    data-group="{{ $group->id }}"
                                >
                                    <div class="service-card-icon">
                                        @if($group->kode === 'KK')
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <circle cx="9" cy="7" r="4" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        @elseif($group->kode === 'AKTA')
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke-linecap="round" stroke-linejoin="round"/>
                                                <polyline points="14 2 14 8 20 8" stroke-linecap="round" stroke-linejoin="round"/>
                                                <line x1="16" y1="13" x2="8" y2="13" stroke-linecap="round"/>
                                                <line x1="16" y1="17" x2="8" y2="17" stroke-linecap="round"/>
                                            </svg>
                                        @elseif($group->kode === 'KTP')
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <rect x="3" y="4" width="18" height="16" rx="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <circle cx="9" cy="10" r="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M15 8h2" stroke-linecap="round"/>
                                                <path d="M15 12h2" stroke-linecap="round"/>
                                                <path d="M7 16h10" stroke-linecap="round"/>
                                            </svg>
                                        @elseif($group->kode === 'KIA')
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <circle cx="12" cy="8" r="4" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M6 20v-2a6 6 0 0 1 12 0v2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        @elseif($group->kode === 'SURAT_PINDAH')
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M16 3h5v5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M4 20L21 3" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M21 16v5h-5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M15 15l6 6" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M4 4l5 5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        @elseif($group->kode === 'PEREKAMAN')
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" stroke-linecap="round" stroke-linejoin="round"/>
                                                <circle cx="12" cy="13" r="4" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        @else
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <rect x="3" y="4" width="18" height="16" rx="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <span class="service-card-label">
                                        {{ $group->kode === 'SURAT_PINDAH' ? 'SURAT PINDAH' : $group->kode }}
                                    </span>
                                </button>
                            @endforeach
                        </div>


                        {{-- =====================================================
                            DATA PEMOHON (FORM CARD)
                        ====================================================== --}}
                        <div class="form-panel-card">
                            <div class="panel-card-head">
                                <h2>Data Pemohon</h2>
                                <p id="category_hint">Lengkapi data pemohon sesuai jenis pelayanan.</p>
                            </div>

                            @foreach($kelompokPelayanans as $group)
                                <div
                                    class="category-panel hidden"
                                    data-panel="{{ $group->id }}"
                                    data-code="{{ $group->kode }}"
                                >
                                    {{-- HIDDEN JENIS PELAYANAN --}}
                                    <input
                                        type="hidden"
                                        name="jenis_pelayanan_id"
                                        class="jenis-hidden"
                                        value="{{ $group->jenisPelayanans->first()?->id }}"
                                        disabled
                                    >

                                    <div class="field-grid">

                                        {{-- DROPDOWN SUB-JENIS (Jika ada: KK, AKTA, KTP) --}}
                                        @if(in_array($group->kode, ['AKTA', 'KTP', 'KK']))
                                            <div class="field-group">
                                                <label>
                                                    @if($group->kode === 'AKTA')
                                                        Jenis Akta
                                                    @elseif($group->kode === 'KTP')
                                                        Jenis KTP
                                                    @else
                                                        Jenis KK
                                                    @endif
                                                    <span class="req">*</span>
                                                </label>

                                                <select
                                                    name="jenis_pelayanan_select"
                                                    class="jenis-dropdown hidden"
                                                    data-group="{{ $group->id }}"
                                                    disabled
                                                    tabindex="-1"
                                                    aria-hidden="true"
                                                >
                                                    <option value="">
                                                        Pilih @if($group->kode === 'AKTA')Jenis Akta @elseif($group->kode === 'KTP')Jenis KTP @else Jenis KK @endif
                                                    </option>

                                                    @foreach($group->jenisPelayanans as $jenis)
                                                        <option
                                                            value="{{ $jenis->id }}"
                                                            {{ (string)$selectedJenisId === (string)$jenis->id ? 'selected' : '' }}
                                                        >
                                                            {{ $jenis->nama_pelayanan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                    <div class="jenis-search-wrapper">
                                                        <input
                                                            type="text"
                                                            class="input-control jenis-search"
                                                            data-group="{{ $group->id }}"
                                                            value="{{ $selectedJenis?->kelompok_pelayanan_id == $group->id ? $selectedJenis->nama_pelayanan : '' }}"
                                                            placeholder="Ketik atau pilih jenis pelayanan"
                                                            autocomplete="off"
                                                            disabled
                                                            required
                                                        >
                                                        <button type="button" class="jenis-search-toggle" tabindex="-1" aria-label="Tampilkan pilihan jenis pelayanan"></button>
                                                        <div class="jenis-suggestions" role="listbox" hidden>
                                                            @foreach($group->jenisPelayanans as $jenis)
                                                                <button
                                                                    type="button"
                                                                    class="jenis-suggestion"
                                                                    data-value="{{ $jenis->id }}"
                                                                    data-label="{{ $jenis->nama_pelayanan }}"
                                                                    role="option"
                                                                >
                                                                    {{ $jenis->nama_pelayanan }}
                                                                </button>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                            </div>
                                        @endif

                                        {{-- TANGGAL PERMOHONAN --}}
                                        <div class="field-group">
                                            <label>Tanggal Permohonan <span class="req">*</span></label>
                                            <div class="date-input-wrapper">
                                                <input
                                                    type="date"
                                                    name="tanggal_permohonan"
                                                    value="{{ old('tanggal_permohonan', isset($permohonan) ? $permohonan->tanggal_permohonan?->format('Y-m-d') : now()->format('Y-m-d')) }}"
                                                    required
                                                    class="input-control"
                                                    disabled
                                                >
                                                <button type="button" class="calendar-button" aria-label="Buka kalender tanggal permohonan">
                                                    <svg class="calendar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="1.8"/>
                                                    <line x1="16" y1="2" x2="16" y2="6" stroke-width="1.8"/>
                                                    <line x1="8" y1="2" x2="8" y2="6" stroke-width="1.8"/>
                                                    <line x1="3" y1="10" x2="21" y2="10" stroke-width="1.8"/>
                                                    </svg>
                                                </button>
                                                <div class="calendar-popover" hidden></div>
                                            </div>
                                        </div>

                                        {{-- NAMA LENGKAP --}}
                                        <div class="field-group">
                                            <label>Nama Lengkap <span class="req">*</span></label>
                                            <input
                                                type="text"
                                                name="nama_pemohon"
                                                value="{{ old('nama_pemohon', $permohonan->nama_pemohon ?? '') }}"
                                                required
                                                class="input-control uppercase-input"
                                                placeholder="Masukkan nama lengkap"
                                                disabled
                                            >
                                        </div>

                                        {{-- FORM SPESIFIK DETAIL --}}
                                        @if($group->kode === 'AKTA')
                                            <div class="field-group">
                                                <label>No Kendali <span class="req">*</span></label>
                                                <input
                                                    type="text"
                                                    name="detail_data[no_kendali]"
                                                    value="{{ old('detail_data.no_kendali', $detail['no_kendali'] ?? $detail['no_akta'] ?? '') }}"
                                                    class="input-control"
                                                    placeholder="Masukkan No. Kendali"
                                                    disabled
                                                    required
                                                >
                                            </div>
                                        @endif

                                        {{-- KECAMATAN --}}
                                        <div class="field-group">
                                            <label>Kecamatan <span class="req">*</span></label>
                                            <select
                                                name="kecamatan_id"
                                                class="kecamatan-select hidden"
                                                required
                                                disabled
                                            >
                                                <option value="">Pilih Kecamatan</option>
                                                @foreach($kecamatans as $kecamatan)
                                                    <option
                                                        value="{{ $kecamatan->id }}"
                                                        {{ (string)old('kecamatan_id', $permohonan->kecamatan_id ?? '') === (string)$kecamatan->id ? 'selected' : '' }}
                                                    >
                                                        {{ $kecamatan->nama_kecamatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="jenis-search-wrapper location-search-wrapper">
                                                <input
                                                    type="text"
                                                    class="input-control location-search kecamatan-search uppercase-input"
                                                    value="{{ $kecamatans->firstWhere('id', old('kecamatan_id', $permohonan->kecamatan_id ?? null))?->nama_kecamatan }}"
                                                    placeholder="Ketik atau pilih kecamatan"
                                                    autocomplete="off"
                                                    disabled
                                                    required
                                                >
                                                <button type="button" class="jenis-search-toggle location-search-toggle" tabindex="-1" aria-label="Tampilkan pilihan kecamatan"></button>
                                                <div class="jenis-suggestions location-suggestions" role="listbox" hidden>
                                                    @foreach($kecamatans as $kecamatan)
                                                        <button type="button" class="jenis-suggestion location-suggestion" data-value="{{ $kecamatan->id }}" data-label="{{ $kecamatan->nama_kecamatan }}" role="option">
                                                            {{ $kecamatan->nama_kecamatan }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        {{-- DESA / KELURAHAN --}}
                                        <div class="field-group">
                                            <label>Desa / Kelurahan <span class="req">*</span></label>
                                            <select
                                                name="desa_id"
                                                class="desa-select hidden"
                                                required
                                                disabled
                                            >
                                                <option value="">Pilih Desa / Kelurahan</option>
                                                @foreach($desas as $desa)
                                                    <option
                                                        value="{{ $desa->id }}"
                                                        data-kecamatan="{{ $desa->kecamatan_id }}"
                                                        {{ (string)old('desa_id', $permohonan->desa_id ?? '') === (string)$desa->id ? 'selected' : '' }}
                                                    >
                                                        {{ $desa->nama_desa }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="jenis-search-wrapper location-search-wrapper">
                                                <input
                                                    type="text"
                                                    class="input-control location-search desa-search uppercase-input"
                                                    value="{{ $desas->firstWhere('id', old('desa_id', $permohonan->desa_id ?? null))?->nama_desa }}"
                                                    placeholder="Ketik atau pilih desa/kelurahan"
                                                    autocomplete="off"
                                                    disabled
                                                    required
                                                >
                                                <button type="button" class="jenis-search-toggle location-search-toggle" tabindex="-1" aria-label="Tampilkan pilihan desa atau kelurahan"></button>
                                                <div class="jenis-suggestions location-suggestions" role="listbox" hidden>
                                                    @foreach($desas as $desa)
                                                        <button type="button" class="jenis-suggestion location-suggestion" data-value="{{ $desa->id }}" data-label="{{ $desa->nama_desa }}" data-kecamatan="{{ $desa->kecamatan_id }}" role="option">
                                                            {{ $desa->nama_desa }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        {{-- KETERANGAN (SIAPA PEMOHONNYA) --}}
                                        <div class="field-group is-full">
                                            <label>Keterangan <span class="text-slate-400 font-normal text-xs">(Pemohon: YBS, Anak, Istri, atau Nama)</span></label>
                                            <input
                                                type="text"
                                                name="keterangan"
                                                value="{{ old('keterangan', $permohonan->keterangan ?? '') }}"
                                                class="input-control uppercase-input"
                                                placeholder="Contoh: YBS (Yang Bersangkutan), Anak, Istri, atau Nama"
                                                disabled
                                            >
                                        </div>

                                    </div>
                                </div>
                            @endforeach

                            {{-- EMPTY STATE JIKA BELUM PILIH --}}
                            <div id="empty_state" class="py-8 text-center" style="color:#64748b;">
                                <p>Silakan pilih jenis pelayanan di atas untuk menampilkan form.</p>
                            </div>
                        </div>

                        {{-- =====================================================
                            ACTION BUTTONS (BATAL / SIMPAN REKAP)
                        ====================================================== --}}
                        <div class="form-actions">
                            <a href="{{ route('permohonan.index') }}" class="btn-batal">
                                Batal
                            </a>
                            <button type="submit" class="btn-simpan">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" stroke-linecap="round" stroke-linejoin="round"/>
                                    <polyline points="17 21 17 13 7 13 7 21" stroke-linecap="round" stroke-linejoin="round"/>
                                    <polyline points="7 3 7 8 15 8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>Simpan Rekap</span>
                            </button>
                        </div>
                    </form>

                    {{-- FOOTER COPYRIGHT --}}
                    <footer class="sipper-footer">
                        © {{ date('Y') }} Dinas Kependudukan dan Pencatatan Sipil Kabupaten Magetan. All rights reserved.
                    </footer>

                </div>

            </div>
        </main>

    </div>

    {{-- =====================================================
        SCRIPT LOGIC
    ====================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = Array.from(document.querySelectorAll('.service-tab'));
            const panels = Array.from(document.querySelectorAll('.category-panel'));
            const empty = document.getElementById('empty_state');
            const hint = document.getElementById('category_hint');

            function uppercaseInput(input) {
                input.value = input.value.toUpperCase();
            }

            function normalize(value) {
                return String(value || '').trim().toLowerCase();
            }

            function matchesJenisQuery(label, query) {
                const normalizedLabel = normalize(label);
                const terms = normalize(query).split(/\s+/).filter(Boolean);

                return terms.length > 0 && terms.every(term => normalizedLabel.includes(term));
            }

            function findJenisMatch(search) {
                const panel = search.closest('.category-panel');
                const dropdown = panel?.querySelector('.jenis-dropdown');
                if (!dropdown) return null;

                return Array.from(dropdown.options)
                    .filter(option => option.value)
                    .find(option => matchesJenisQuery(option.textContent, search.value));
            }

            function syncJenisSearch(search) {
                const panel = search.closest('.category-panel');
                const dropdown = panel?.querySelector('.jenis-dropdown');
                const hidden = panel?.querySelector('.jenis-hidden');
                if (!dropdown || !hidden) return;

                const query = normalize(search.value);
                const match = query ? findJenisMatch(search) : null;

                if (match) {
                    dropdown.value = match.value;
                    hidden.value = match.value;
                    search.setCustomValidity('');
                } else {
                    dropdown.value = '';
                    hidden.value = '';
                    search.setCustomValidity('Pilih salah satu jenis pelayanan yang tersedia.');
                }
            }

            function renderJenisSuggestions(search, showAll = false) {
                const wrapper = search.closest('.jenis-search-wrapper');
                const menu = wrapper?.querySelector('.jenis-suggestions');
                if (!menu) return;

                const query = normalize(search.value);
                const suggestions = Array.from(menu.querySelectorAll('.jenis-suggestion'));
                let visibleCount = 0;

                suggestions.forEach(suggestion => {
                    const matches = showAll || matchesJenisQuery(suggestion.dataset.label, query);
                    suggestion.hidden = !matches;
                    if (matches) visibleCount += 1;
                });

                menu.hidden = visibleCount === 0;
                search.dataset.suggestionIndex = '-1';
            }

            function highlightJenisSuggestion(search, direction) {
                const menu = search.closest('.jenis-search-wrapper')?.querySelector('.jenis-suggestions');
                if (!menu) return;

                if (menu.hidden) renderJenisSuggestions(search, !normalize(search.value));

                const visible = Array.from(menu.querySelectorAll('.jenis-suggestion:not([hidden])'));
                if (!visible.length) return;

                const currentIndex = Number(search.dataset.suggestionIndex || -1);
                const nextIndex = currentIndex < 0
                    ? (direction > 0 ? 0 : visible.length - 1)
                    : (currentIndex + direction + visible.length) % visible.length;

                visible.forEach(suggestion => suggestion.classList.remove('is-highlighted'));
                visible[nextIndex].classList.add('is-highlighted');
                visible[nextIndex].scrollIntoView({ block: 'nearest' });
                search.dataset.suggestionIndex = String(nextIndex);
            }

            function closeJenisSuggestions() {
                document.querySelectorAll('.jenis-suggestions').forEach(menu => {
                    menu.hidden = true;
                });
            }

            function locationMatches(label, query) {
                const terms = normalize(query).split(/\s+/).filter(Boolean);
                const normalizedLabel = normalize(label);

                return terms.length > 0 && terms.every(term => normalizedLabel.includes(term));
            }

            function findLocationMatch(search) {
                const wrapper = search.closest('.location-search-wrapper');
                const select = wrapper?.previousElementSibling;
                if (!select) return null;

                const kecamatan = search.classList.contains('desa-search')
                    ? search.closest('.category-panel')?.querySelector('.kecamatan-select')?.value
                    : null;

                return Array.from(select.options)
                    .filter(option => option.value)
                    .find(option => {
                        if (kecamatan && option.dataset.kecamatan !== String(kecamatan)) return false;
                        return locationMatches(option.textContent, search.value);
                    });
            }

            function syncLocationSearch(search) {
                const wrapper = search.closest('.location-search-wrapper');
                const select = wrapper?.previousElementSibling;
                if (!select) return;

                uppercaseInput(search);

                const match = normalize(search.value) ? findLocationMatch(search) : null;
                select.value = match?.value || '';
                search.setCustomValidity(match ? '' : 'Pilih salah satu pilihan yang tersedia.');

                if (search.classList.contains('kecamatan-search')) {
                    filterDesa(search.closest('.category-panel'));
                }
            }

            function renderLocationSuggestions(search, showAll = false) {
                const wrapper = search.closest('.location-search-wrapper');
                const menu = wrapper?.querySelector('.location-suggestions');
                if (!menu) return;

                const query = normalize(search.value);
                const kecamatan = search.classList.contains('desa-search')
                    ? search.closest('.category-panel')?.querySelector('.kecamatan-select')?.value
                    : null;
                const suggestions = Array.from(menu.querySelectorAll('.location-suggestion'));
                let visibleCount = 0;

                suggestions.forEach(suggestion => {
                    const belongsToKecamatan = !kecamatan || suggestion.dataset.kecamatan === String(kecamatan);
                    const matches = belongsToKecamatan && (showAll || locationMatches(suggestion.dataset.label, query));
                    suggestion.hidden = !matches;
                    suggestion.classList.remove('is-highlighted');
                    if (matches) visibleCount += 1;
                });

                menu.hidden = visibleCount === 0;
                search.dataset.suggestionIndex = '-1';
            }

            function highlightLocationSuggestion(search, direction) {
                const menu = search.closest('.location-search-wrapper')?.querySelector('.location-suggestions');
                if (!menu) return;

                if (menu.hidden) renderLocationSuggestions(search, !normalize(search.value));

                const visible = Array.from(menu.querySelectorAll('.location-suggestion:not([hidden])'));
                if (!visible.length) return;

                const currentIndex = Number(search.dataset.suggestionIndex || -1);
                const nextIndex = currentIndex < 0
                    ? (direction > 0 ? 0 : visible.length - 1)
                    : (currentIndex + direction + visible.length) % visible.length;

                visible.forEach(suggestion => suggestion.classList.remove('is-highlighted'));
                visible[nextIndex].classList.add('is-highlighted');
                visible[nextIndex].scrollIntoView({ block: 'nearest' });
                search.dataset.suggestionIndex = String(nextIndex);
            }

            function bindLocationSearch(search) {
                const wrapper = search.closest('.location-search-wrapper');
                const toggle = wrapper?.querySelector('.location-search-toggle');
                const menu = wrapper?.querySelector('.location-suggestions');

                search.addEventListener('input', () => {
                    syncLocationSearch(search);
                    renderLocationSuggestions(search);
                });

                search.addEventListener('keydown', event => {
                    if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
                        event.preventDefault();
                        highlightLocationSuggestion(search, event.key === 'ArrowDown' ? 1 : -1);
                        return;
                    }

                    if (event.key === 'Escape') {
                        event.preventDefault();
                        closeJenisSuggestions();
                        return;
                    }

                    if (event.key !== 'Enter') return;
                    event.preventDefault();

                    const suggestionsOpen = menu && !menu.hidden;

                    const highlighted = wrapper?.querySelector('.location-suggestion.is-highlighted');
                    const match = highlighted || findLocationMatch(search);
                    if (!match) {
                        syncLocationSearch(search);
                        if (suggestionsOpen) event.stopPropagation();
                        return;
                    }

                    search.value = match.dataset.label || match.textContent.trim();
                    syncLocationSearch(search);
                    renderLocationSuggestions(search);
                    closeJenisSuggestions();
                    if (suggestionsOpen) event.stopPropagation();
                });

                toggle?.addEventListener('click', () => {
                    if (menu?.hidden) {
                        search.focus();
                        renderLocationSuggestions(search, true);
                    } else {
                        closeJenisSuggestions();
                    }
                });

                menu?.querySelectorAll('.location-suggestion').forEach(suggestion => {
                    suggestion.addEventListener('click', () => {
                        search.value = suggestion.dataset.label || '';
                        syncLocationSearch(search);
                        closeJenisSuggestions();
                    });
                });
            }

            function filterDesa(panel) {
                const kecamatan = panel.querySelector('.kecamatan-select');
                const desa = panel.querySelector('.desa-select');
                if (!kecamatan || !desa) return;

                const selectedKec = kecamatan.value;
                const options = Array.from(desa.options);

                options.forEach(opt => {
                    if (!opt.value) return;
                    const match = opt.dataset.kecamatan === String(selectedKec);
                    opt.style.display = match ? '' : 'none';
                });

                const desaSearch = panel.querySelector('.desa-search');
                if (desaSearch) {
                    renderLocationSuggestions(desaSearch, false);
                    const selectedDesa = desa.selectedOptions[0];
                    if (selectedDesa?.value && selectedDesa.dataset.kecamatan === String(selectedKec)) {
                        desaSearch.value = selectedDesa.textContent.trim();
                    } else if (!selectedKec) {
                        desaSearch.value = '';
                    }
                }

                if (desa.selectedOptions[0] && desa.selectedOptions[0].style.display === 'none') {
                    desa.value = '';
                    if (desaSearch) desaSearch.value = '';
                }
            }

            function activate(groupId) {
                tabs.forEach(t => {
                    const active = String(t.dataset.group) === String(groupId);
                    t.classList.toggle('is-active', active);
                });

                panels.forEach(panel => {
                    const active = String(panel.dataset.panel) === String(groupId);
                    panel.classList.toggle('hidden', !active);

                    const inputs = panel.querySelectorAll('input, select, textarea');
                    inputs.forEach(el => {
                        el.disabled = !active;
                    });

                    const hidden = panel.querySelector('.jenis-hidden');
                    const dropdown = panel.querySelector('.jenis-dropdown');

                    if (active) {
                        if (dropdown) {
                            dropdown.disabled = false;
                            if (hidden) {
                                hidden.disabled = false;
                                if (dropdown.value) {
                                    hidden.value = dropdown.value;
                                }
                            }
                        } else if (hidden) {
                            hidden.disabled = false;
                        }

                        const search = panel.querySelector('.jenis-search');
                        if (search && dropdown?.value && !search.value) {
                            search.value = dropdown.selectedOptions[0]?.textContent.trim() || '';
                        }

                        // Attach event listeners for kecamatan / desa cascading filter
                        const kecamatan = panel.querySelector('.kecamatan-select');
                        if (kecamatan) {
                            kecamatan.addEventListener('change', () => filterDesa(panel));
                        }
                        filterDesa(panel);
                    }
                });

                if (empty) {
                    empty.classList.toggle('hidden', !!groupId);
                }

                const activeTab = tabs.find(t => String(t.dataset.group) === String(groupId));
                if (hint) {
                    hint.textContent = activeTab
                        ? 'Lengkapi data pemohon sesuai jenis pelayanan.'
                        : 'Isi data sesuai jenis pelayanan yang dipilih.';
                }
            }

            document.querySelectorAll('.jenis-dropdown').forEach(dropdown => {
                dropdown.addEventListener('change', () => {
                    const panel = dropdown.closest('.category-panel');
                    const hidden = panel.querySelector('.jenis-hidden');
                    const search = panel.querySelector('.jenis-search');
                    if (hidden) {
                        hidden.value = dropdown.value;
                    }
                    if (search) {
                        search.value = dropdown.selectedOptions[0]?.textContent.trim() || '';
                    }
                });
            });

            document.querySelectorAll('.jenis-search').forEach(search => {
                search.addEventListener('input', () => {
                    syncJenisSearch(search);
                    renderJenisSuggestions(search);
                });
                search.addEventListener('change', () => syncJenisSearch(search));
                search.addEventListener('keydown', event => {
                    if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
                        event.preventDefault();
                        highlightJenisSuggestion(search, event.key === 'ArrowDown' ? 1 : -1);
                        return;
                    }

                    if (event.key !== 'Enter') return;

                    event.preventDefault();
                    const suggestionsOpen = menu && !menu.hidden;
                    const highlighted = search.closest('.jenis-search-wrapper')
                        ?.querySelector('.jenis-suggestion.is-highlighted');
                    const match = highlighted || findJenisMatch(search);
                    if (!match) {
                        syncJenisSearch(search);
                        if (suggestionsOpen) event.stopPropagation();
                        return;
                    }

                    search.value = match.dataset.label || match.textContent.trim();
                    syncJenisSearch(search);
                    closeJenisSuggestions();
                    if (suggestionsOpen) event.stopPropagation();
                });

                const wrapper = search.closest('.jenis-search-wrapper');
                const toggle = wrapper?.querySelector('.jenis-search-toggle');
                const menu = wrapper?.querySelector('.jenis-suggestions');

                toggle?.addEventListener('click', () => {
                    if (menu?.hidden) {
                        search.focus();
                        renderJenisSuggestions(search, true);
                    } else {
                        closeJenisSuggestions();
                    }
                });

                menu?.querySelectorAll('.jenis-suggestion').forEach(suggestion => {
                    suggestion.addEventListener('click', () => {
                        search.value = suggestion.dataset.label || '';
                        syncJenisSearch(search);
                        closeJenisSuggestions();
                    });
                });
            });

            document.querySelectorAll('.location-search').forEach(bindLocationSearch);

            const monthNames = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            const monthShortNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
            const dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

            function parseDate(value) {
                const [year, month, day] = String(value || '').split('-').map(Number);
                return year && month && day ? new Date(year, month - 1, day) : new Date();
            }

            function formatDate(date) {
                return [date.getFullYear(), String(date.getMonth() + 1).padStart(2, '0'), String(date.getDate()).padStart(2, '0')].join('-');
            }

            function closeCalendars(except = null) {
                document.querySelectorAll('.calendar-popover').forEach(calendar => {
                    if (calendar !== except) calendar.hidden = true;
                });
            }

            document.querySelectorAll('.date-input-wrapper').forEach(wrapper => {
                const input = wrapper.querySelector('input[type="date"]');
                const button = wrapper.querySelector('.calendar-button');
                const calendar = wrapper.querySelector('.calendar-popover');
                if (!input || !button || !calendar) return;

                let visibleMonth = parseDate(input.value);
                let periodMode = 'dates';

                function renderCalendar() {
                    const year = visibleMonth.getFullYear();
                    const month = visibleMonth.getMonth();
                    const selected = input.value;
                    const firstDay = new Date(year, month, 1).getDay();
                    const daysInMonth = new Date(year, month + 1, 0).getDate();
                    const cells = [];

                    for (let index = 0; index < firstDay; index += 1) cells.push('<span></span>');
                    for (let day = 1; day <= daysInMonth; day += 1) {
                        const date = formatDate(new Date(year, month, day));
                        cells.push(`<button type="button" class="calendar-day${date === selected ? ' is-selected' : ''}" data-date="${date}">${day}</button>`);
                    }

                    const yearOptions = Array.from({ length: 21 }, (_, index) => year - 10 + index);

                    calendar.innerHTML = `
                        <div class="calendar-head">
                            <button type="button" class="calendar-nav" data-month="-1" aria-label="Bulan sebelumnya">‹</button>
                            <div class="calendar-period-buttons">
                                <button type="button" class="calendar-period-toggle calendar-month-toggle">${monthShortNames[month]}</button>
                                <button type="button" class="calendar-period-toggle calendar-year-toggle">${year}</button>
                            </div>
                            <button type="button" class="calendar-nav" data-month="1" aria-label="Bulan berikutnya">›</button>
                        </div>
                        <div class="calendar-period-picker"${periodMode === 'dates' ? ' hidden' : ''}>
                            <div class="calendar-period-section" data-period-section="months"${periodMode !== 'months' ? ' hidden' : ''}>
                                <span>Bulan</span>
                                <div class="calendar-month-options">${monthShortNames.map((name, index) => `<button type="button" class="calendar-period-option${index === month ? ' is-active' : ''}" data-month-value="${index}" aria-label="${monthNames[index]}">${name}</button>`).join('')}</div>
                            </div>
                            <div class="calendar-period-section" data-period-section="years"${periodMode !== 'years' ? ' hidden' : ''}>
                                <span>Tahun</span>
                                <div class="calendar-year-options">${yearOptions.map(optionYear => `<button type="button" class="calendar-period-option${optionYear === year ? ' is-active' : ''}" data-year-value="${optionYear}">${optionYear}</button>`).join('')}</div>
                            </div>
                        </div>
                        <div class="calendar-weekdays">${dayNames.map(day => `<span>${day}</span>`).join('')}</div>
                        <div class="calendar-days">${cells.join('')}</div>
                        <button type="button" class="calendar-today">Hari ini</button>
                    `;
                    calendar.querySelectorAll('.calendar-nav').forEach(nav => nav.addEventListener('click', event => {
                        event.stopPropagation();
                        visibleMonth.setMonth(visibleMonth.getMonth() + Number(nav.dataset.month));
                        renderCalendar();
                    }));
                    calendar.querySelector('.calendar-month-toggle')?.addEventListener('click', event => {
                        event.stopPropagation();
                        periodMode = 'months';
                        renderCalendar();
                        calendar.hidden = false;
                    });
                    calendar.querySelector('.calendar-year-toggle')?.addEventListener('click', event => {
                        event.stopPropagation();
                        periodMode = 'years';
                        renderCalendar();
                        calendar.hidden = false;
                    });
                    calendar.querySelectorAll('[data-month-value]').forEach(option => option.addEventListener('click', event => {
                        event.stopPropagation();
                        visibleMonth.setMonth(Number(option.dataset.monthValue));
                        periodMode = 'dates';
                        renderCalendar();
                        calendar.hidden = false;
                    }));
                    calendar.querySelectorAll('[data-year-value]').forEach(option => option.addEventListener('click', event => {
                        event.stopPropagation();
                        visibleMonth.setFullYear(Number(option.dataset.yearValue));
                        periodMode = 'dates';
                        renderCalendar();
                        calendar.hidden = false;
                    }));
                    calendar.querySelectorAll('.calendar-day').forEach(day => day.addEventListener('click', () => {
                        input.value = day.dataset.date;
                        input.dispatchEvent(new Event('change', { bubbles: true }));
                        calendar.hidden = true;
                    }));
                    calendar.querySelector('.calendar-today')?.addEventListener('click', () => {
                        const today = new Date();
                        input.value = formatDate(today);
                        input.dispatchEvent(new Event('change', { bubbles: true }));
                        calendar.hidden = true;
                    });
                }

                button.addEventListener('click', () => {
                    if (input.disabled) return;
                    closeCalendars(calendar);
                    visibleMonth = new Date();
                    periodMode = 'dates';
                    renderCalendar();
                    calendar.hidden = false;
                });
            });

            document.addEventListener('click', event => {
                if (!event.target.closest('.date-input-wrapper')) closeCalendars();
            });

            document.querySelectorAll('.uppercase-input').forEach(input => {
                uppercaseInput(input);
                input.addEventListener('input', () => uppercaseInput(input));
            });

            const form = document.querySelector('.form-page-container form');

            form?.addEventListener('keydown', event => {
                if (event.key !== 'Enter') return;

                const current = event.target;
                if (!(current instanceof HTMLInputElement || current instanceof HTMLSelectElement)) return;

                const openSuggestions = current.closest('.jenis-search-wrapper, .location-search-wrapper')
                    ?.querySelector('.jenis-suggestions:not([hidden]), .location-suggestions:not([hidden])');
                if (openSuggestions) return;

                const fields = Array.from(form.querySelectorAll('input:not([type="hidden"]), select, textarea'))
                    .filter(field => !field.disabled && field.offsetParent !== null);
                const currentIndex = fields.indexOf(current);
                const nextField = fields[currentIndex + 1];

                event.preventDefault();

                if (!String(current.value || '').trim()) {
                    current.reportValidity();
                    current.focus();
                    return;
                }

                if (form.checkValidity()) {
                    form.requestSubmit();
                    return;
                }

                nextField?.focus();
            });

            form?.addEventListener('submit', () => {
                document.querySelectorAll('.uppercase-input').forEach(uppercaseInput);
            });

            document.addEventListener('click', event => {
                if (!event.target.closest('.jenis-search-wrapper')) {
                    closeJenisSuggestions();
                }
            });

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    activate(tab.dataset.group);
                });
            });

            const initialGroup = document.getElementById('selected_group').value;
            if (initialGroup) {
                activate(initialGroup);
            } else if (tabs.length) {
                activate(tabs[0].dataset.group);
            }
        });
    </script>

</body>

</html>