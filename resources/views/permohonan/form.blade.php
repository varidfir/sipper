<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ isset($permohonan) ? 'Edit Rekap' : 'Input Rekap' }} - Sistem Rekap
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

                        <a href="{{ route('permohonan.index') }}" class="btn-back">
                            ← Kembali
                        </a>
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
                                                    class="input-control jenis-dropdown"
                                                    data-group="{{ $group->id }}"
                                                    disabled
                                                    required
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
                                            </div>
                                        @endif

                                        {{-- TANGGAL PERMOHONAN --}}
                                        <div class="field-group">
                                            <label>Tanggal Permohonan <span class="req">*</span></label>
                                            <div class="date-input-wrapper">
                                                <input
                                                    type="text"
                                                    name="tanggal_permohonan"
                                                    value="{{ old('tanggal_permohonan', isset($permohonan) ? $permohonan->tanggal_permohonan?->format('d/m/Y') : now()->format('d/m/Y')) }}"
                                                    required
                                                    class="input-control"
                                                    disabled
                                                >
                                                <svg class="calendar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="1.8"/>
                                                    <line x1="16" y1="2" x2="16" y2="6" stroke-width="1.8"/>
                                                    <line x1="8" y1="2" x2="8" y2="6" stroke-width="1.8"/>
                                                    <line x1="3" y1="10" x2="21" y2="10" stroke-width="1.8"/>
                                                </svg>
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
                                                class="input-control"
                                                placeholder="Masukkan nama lengkap"
                                                disabled
                                            >
                                        </div>

                                        {{-- KETERANGAN / HUBUNGAN / FORM SPESIFIK DETAIL --}}
                                        @if($group->kode === 'KK')
                                            <div class="field-group">
                                                <label>Keterangan / Hubungan <span class="req">*</span></label>
                                                <input
                                                    type="text"
                                                    name="detail_data[keterangan_hubungan]"
                                                    value="{{ old('detail_data.keterangan_hubungan', $detail['keterangan_hubungan'] ?? '') }}"
                                                    class="input-control"
                                                    placeholder="Contoh: Suami, Istri, Anak, Orang Tua, dll"
                                                    disabled
                                                >
                                            </div>
                                        @elseif($group->kode === 'AKTA')
                                            <div class="field-group">
                                                <label>Nomor Akta / Keterangan</label>
                                                <input
                                                    type="text"
                                                    name="detail_data[no_akta]"
                                                    value="{{ old('detail_data.no_akta', $detail['no_akta'] ?? '') }}"
                                                    class="input-control"
                                                    placeholder="Masukkan nomor akta atau keterangan"
                                                    disabled
                                                >
                                            </div>
                                        @elseif($group->kode === 'KTP')
                                            <div class="field-group">
                                                <label>NIK / Keterangan KTP</label>
                                                <input
                                                    type="text"
                                                    name="detail_data[nik]"
                                                    value="{{ old('detail_data.nik', $detail['nik'] ?? '') }}"
                                                    class="input-control"
                                                    placeholder="Masukkan NIK atau keterangan KTP"
                                                    disabled
                                                >
                                            </div>
                                        @elseif($group->kode === 'KIA')
                                            <div class="field-group">
                                                <label>Nama Anak / Keterangan KIA</label>
                                                <input
                                                    type="text"
                                                    name="detail_data[nama_anak]"
                                                    value="{{ old('detail_data.nama_anak', $detail['nama_anak'] ?? '') }}"
                                                    class="input-control"
                                                    placeholder="Masukkan nama anak atau keterangan"
                                                    disabled
                                                >
                                            </div>
                                        @elseif($group->kode === 'SURAT_PINDAH')
                                            <div class="field-group">
                                                <label>Alamat Tujuan / Keterangan Pindah</label>
                                                <input
                                                    type="text"
                                                    name="detail_data[alamat_tujuan]"
                                                    value="{{ old('detail_data.alamat_tujuan', $detail['alamat_tujuan'] ?? '') }}"
                                                    class="input-control"
                                                    placeholder="Masukkan alamat tujuan atau keterangan"
                                                    disabled
                                                >
                                            </div>
                                        @elseif($group->kode === 'PEREKAMAN')
                                            <div class="field-group">
                                                <label>Status / Keterangan Perekaman</label>
                                                <input
                                                    type="text"
                                                    name="detail_data[status_perekaman]"
                                                    value="{{ old('detail_data.status_perekaman', $detail['status_perekaman'] ?? '') }}"
                                                    class="input-control"
                                                    placeholder="Contoh: Bio-Capture, Retake, dll"
                                                    disabled
                                                >
                                            </div>
                                        @endif

                                        {{-- KECAMATAN --}}
                                        <div class="field-group">
                                            <label>Kecamatan <span class="req">*</span></label>
                                            <select
                                                name="kecamatan_id"
                                                class="input-control kecamatan-select"
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
                                        </div>

                                        {{-- DESA / KELURAHAN --}}
                                        <div class="field-group">
                                            <label>Desa / Kelurahan <span class="req">*</span></label>
                                            <select
                                                name="desa_id"
                                                class="input-control desa-select"
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
                                        </div>

                                        {{-- KETERANGAN TAMBAHAN --}}
                                        <div class="field-group is-full">
                                            <label>Keterangan Tambahan</label>
                                            <input
                                                type="text"
                                                name="keterangan"
                                                value="{{ old('keterangan', $permohonan->keterangan ?? '') }}"
                                                class="input-control"
                                                placeholder="Tambahkan keterangan jika diperlukan"
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

                if (desa.selectedOptions[0] && desa.selectedOptions[0].style.display === 'none') {
                    desa.value = '';
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
                    if (hidden) {
                        hidden.value = dropdown.value;
                    }
                });
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