<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Permohonan - SIPPER</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --page-bg: var(--sip-bg);
            --panel-bg: var(--sip-panel);
            --panel-soft: #f8fafc;
            --line: var(--sip-border);
            --line-strong: #d8e1ec;
            --text: var(--sip-text);
            --muted: var(--sip-muted);
            --muted-soft: #8b93a4;
            --primary: var(--sip-primary);
            --primary-dark: var(--sip-primary-hover);
            --primary-soft: var(--sip-primary-soft);
            --primary-border: var(--sip-primary-border);
            --primary-deep: var(--sip-sidebar-bg);
            --shadow: 0 8px 22px rgba(15, 23, 42, 0.04);
        }

        * { box-sizing: border-box; }
        html, body { margin: 0; }
        body {
            background: var(--page-bg);
            color: var(--text);
            font-family: Inter, "Segoe UI", Roboto, Arial, sans-serif;
        }

        .sipper-page {
            padding: 18px 24px 30px;
        }

        .sipper-panel {
            background: var(--panel-bg);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 18px 20px 16px;
        }

        .page-top {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .page-badge {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .06em;
            color: var(--primary);
            text-transform: uppercase;
            margin: 0 0 8px;
        }

        .page-title {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            line-height: 1.2;
            color: #0f172a;
        }

        .page-subtitle {
            margin: 8px 0 0;
            font-size: 13px;
            color: var(--muted);
        }

        .primary-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 42px;
            padding: 0 18px;
            border: none;
            background: var(--primary);
            color: #fff;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            box-shadow: 0 10px 18px rgba(29, 78, 216, 0.18);
            text-decoration: none;
        }

        .filter-card {
            background: #f6f8fb;
            border: 1px solid var(--line);
            border-radius: 14px;
            overflow: visible;
        }

        .filter-head {
            padding: 8px 12px 5px;
        }

        .filter-head h2 {
            margin: 0;
            font-size: 12px;
            font-weight: 700;
            color: #1f2937;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 8px 12px;
            padding: 10px 12px 12px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .field.wide { grid-column: span 2; }

        .field label {
            font-size: 10px;
            font-weight: 600;
            color: #475467;
        }

        .field input,
        .field select {
            width: 100%;
            height: 32px;
            border: 1px solid var(--line-strong);
            border-radius: 2px;
            appearance: none;
            background-color: #fff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23334155'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 7px center;
            background-size: 12px 12px;
            color: var(--text);
            padding: 0 8px;
            padding-right: 30px;
            font-size: 11px;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        .field input:focus,
        .field select:focus {
            border-color: var(--sip-primary);
            box-shadow: 0 0 0 3px rgba(29, 97, 232, .12);
        }

        .service-picker { position: relative; }
        .service-picker-toggle {
            width: 100%;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
            border: 1px solid var(--line-strong);
            border-radius: 2px;
            background: #fff;
            color: var(--text);
            padding: 0 8px;
            font-size: 11px;
            line-height: 1;
            text-align: left;
            cursor: pointer;
            box-sizing: border-box;
        }
        .service-picker-toggle:focus,
        .service-picker.is-open .service-picker-toggle {
            border-color: var(--sip-primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(29, 97, 232, .12);
        }
        .service-picker-chevron {
            flex: 0 0 auto;
            width: 6px;
            height: 6px;
            border-right: 1.5px solid #334155;
            border-bottom: 1.5px solid #334155;
            font-size: 0;
            transform: rotate(45deg) translate(-2px, -2px);
            transition: transform .15s;
        }
        .service-picker.is-open .service-picker-chevron { transform: rotate(225deg) translate(-2px, -2px); }
        .service-picker-menu {
            position: absolute;
            z-index: 30;
            top: calc(100% + 4px);
            left: 0;
            width: 100%;
            max-width: 100%;
            max-height: 200px;
            display: block;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 3px;
            overflow-y: auto;
            padding: 5px;
            border: 1px solid var(--line-strong);
            border-radius: 2px;
            background: #fff;
            box-shadow: 0 12px 24px rgba(15, 23, 42, .16);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translateY(-8px) scaleY(.96);
            transform-origin: top center;
            transition: opacity .18s ease, transform .18s ease, visibility 0s linear .18s;
        }
        .service-picker.is-open .service-picker-menu {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateY(0) scaleY(1);
            transition-delay: 0s;
        }
        .service-picker-option {
            width: 100%;
            min-height: 26px;
            border: 1px solid transparent;
            border-radius: 2px;
            background: transparent;
            color: #344054;
            padding: 3px 6px;
            font-size: 10px;
            line-height: 1.25;
            white-space: normal;
            overflow-wrap: anywhere;
            text-align: left;
            cursor: pointer;
        }
        .service-picker-option:hover,
        .service-picker-option.is-selected {
            border-color: var(--sip-primary);
            background: rgba(29, 97, 232, .08);
            color: var(--sip-primary);
            font-weight: 700;
        }
        .service-picker-option[hidden] { display: none; }
        .service-picker-menu::-webkit-scrollbar { width: 6px; }
        .service-picker-menu::-webkit-scrollbar-thumb { border-radius: 6px; background: #cbd5e1; }

        .filter-actions {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 0 12px 10px;
        }

        .btn-secondary {
            background: #f8fafc;
            border: 1px solid var(--line-strong);
            color: #334155;
            border-radius: 10px;
            min-height: 38px;
            padding: 0 16px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .table-section {
            margin-top: 24px;
        }

        .table-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .table-top h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            color: #111827;
        }

        .table-top small {
            font-size: 11px;
            font-weight: 700;
            color: var(--muted-soft);
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .table-wrap {
            border: 1px solid var(--line);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        thead th {
            background: #f4f7fb;
            color: #5b6473;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .03em;
            text-transform: uppercase;
            text-align: left;
            padding: 13px 12px;
            border-bottom: 1px solid var(--line);
        }

        tbody td {
            padding: 14px 12px;
            border-bottom: 1px solid #edf2f7;
            font-size: 12px;
            color: #475467;
            vertical-align: top;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .empty-state {
            text-align: center;
            padding: 44px 20px;
            color: #8b93a4;
        }

        .empty-icon {
            width: 54px;
            height: 54px;
            margin: 0 auto 14px;
            border-radius: 14px;
            background: #f1f5f9;
            border: 1px solid var(--line);
            display: grid;
            place-items: center;
            font-size: 22px;
            color: #98a2b3;
        }

        .empty-text {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }

        @media (max-width: 980px) {
            .filter-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .field.wide { grid-column: span 2; }
        }

        @media (max-width: 720px) {
            .sipper-page {
                padding: 12px 14px 22px;
            }

            .page-top {
                flex-direction: column;
                align-items: flex-start;
            }

            .primary-btn,
            .btn-secondary {
                width: 100%;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .field.wide { grid-column: span 1; }

            .filter-actions {
                flex-direction: column;
                align-items: stretch;
            }
        }

        /* Simple blue administrative layout */
        .sipper-page {
            padding: 18px clamp(16px, 3vw, 32px) 32px;
        }

        .sipper-panel {
            padding: 0;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, .04);
        }

        .page-top {
            align-items: center;
            padding: 18px 20px;
            margin-bottom: 0;
            border-bottom: 1px solid var(--line);
        }

        .form-header {
            padding-right: 20px;
        }

        .page-badge {
            margin-bottom: 5px;
            color: var(--primary);
            font-size: 10px;
        }

        .page-title {
            font-size: 22px;
        }

        .page-subtitle {
            margin-top: 5px;
            font-size: 12px;
        }

        .primary-btn {
            min-height: 36px;
            padding: 0 14px;
            border-radius: 4px;
            background: var(--sip-primary);
            box-shadow: none;
            font-size: 12px;
        }

        .primary-btn:hover {
            background: var(--primary-dark);
        }

        .filter-card {
            margin: 16px 20px 0;
            border-radius: 3px;
            background: #f8fafc;
        }

        .filter-head {
            padding: 12px 14px;
            border-bottom: 1px solid var(--line);
            background: var(--sip-sidebar-bg);
        }

        .filter-head h2 {
            color: #fff;
            font-size: 13px;
        }

        .filter-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px 16px;
            padding: 14px;
        }

        .field {
            gap: 5px;
        }

        .field label {
            color: #475569;
            font-size: 11px;
        }

        .field input,
        .field select {
            min-height: 34px;
            padding: 7px 9px;
            border-radius: 2px;
            font-size: 12px;
        }

        .field input:focus,
        .field select:focus {
            border-color: var(--sip-primary);
            box-shadow: 0 0 0 2px rgba(29, 97, 232, .12);
        }

        .filter-actions {
            padding: 0 14px 14px;
        }

        .btn-secondary {
            min-height: 34px;
            padding: 0 14px;
            border-radius: 2px;
            background: #fff;
            font-size: 12px;
        }

        .table-section {
            margin: 20px;
        }

        .table-top {
            margin-bottom: 8px;
        }

        .table-top h3 {
            font-size: 15px;
        }

        .table-top small {
            font-size: 10px;
        }

        .table-wrap {
            border-radius: 3px;
        }

        thead th {
            padding: 10px 12px;
            background: var(--sip-primary-soft);
            color: var(--sip-primary-hover);
            font-size: 10px;
        }

        tbody td {
            padding: 11px 12px;
            font-size: 11px;
        }

        tbody tr:hover {
            background: #f8fbff;
        }

        .applicant-name {
            color: #1f2937;
            font-weight: 700;
        }

        .application-number {
            margin-top: 3px;
            color: #8b93a4;
            font-size: 10px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 8px;
            border: 1px solid var(--primary-border);
            border-radius: 3px;
            background: var(--sip-primary-soft);
            color: var(--sip-primary);
            font-size: 10px;
            font-weight: 700;
        }

        .empty-icon {
            width: 44px;
            height: 44px;
            margin-bottom: 10px;
            border-radius: 4px;
            background: var(--primary-soft);
            border-color: var(--primary-border);
            color: var(--primary);
            font-size: 18px;
        }

        .empty-text {
            font-size: 13px;
        }

        @media (max-width: 980px) {
            .filter-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 720px) {
            .sipper-page { padding: 12px 14px 22px; }
            .page-top { align-items: flex-start; flex-direction: column; padding: 16px; }
            .filter-card { margin: 12px 14px 0; }
            .table-section { margin: 16px 14px; }
            .filter-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
@include('layouts.sidebar')
<main class="sipper-content">
    @include('layouts.header', ['pageTitle' => 'Data Permohonan'])

    <div class="page-shell">
        <div class="form-page-container">
            <div class="form-header">
                <div class="form-title-group">
                    <h1>Data Permohonan</h1>
                    <p>Kelola dan cari data permohonan layanan.</p>
                </div>
                <a href="{{ route('permohonan.create') }}" class="primary-btn">+ Tambah Permohonan Baru</a>
            </div>

            @if(session('status'))
                <div class="mt-5 rounded-2xl border px-4 py-3 text-sm font-medium" style="border-color:var(--sip-primary-border); background:var(--sip-primary-soft); color:var(--sip-primary);">{{ session('status') }}</div>
            @endif

            <div class="filter-card">
                <div class="filter-head">
                    <h2>Pencarian &amp; Filter</h2>
                </div>

                <form method="GET" action="{{ route('permohonan.index') }}">
                    <div class="filter-grid">
                        <div class="field wide">
                            <label for="search">Pencarian</label>
                            <input id="search" name="search" value="{{ request('search') }}" placeholder="Nomor, nama, keterangan">
                        </div>

                        <div class="field">
                            <label for="date">Tanggal Pengajuan</label>
                            <input id="date" type="date" name="date" value="{{ request('date') }}">
                        </div>

                        <div class="field">
                            <label for="year">Tahun</label>
                            <select id="year" name="year">
                                <option value="">Semua Tahun</option>
                                @foreach(range(2020, date('Y') + 2) as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label for="month">Bulan</label>
                            <select id="month" name="month">
                                <option value="">Semua Bulan</option>
                                @foreach(range(1,12) as $month)
                                    <option value="{{ $month }}" {{ (string) request('month') === (string) $month ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label for="kelompok_pelayanan_id">Kategori Layanan</label>
                            <select id="kelompok_pelayanan_id" name="kelompok_pelayanan_id">
                                <option value="">Semua Kategori</option>
                                @foreach($kelompokPelayanans as $group)
                                    <option value="{{ $group->id }}" {{ request('kelompok_pelayanan_id') == $group->id ? 'selected' : '' }}>{{ $group->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label for="jenis_pelayanan_id">Jenis Layanan</label>
                            @php
                                $selectedServiceId = (string) request('jenis_pelayanan_id');
                                $selectedServiceName = 'Semua Jenis';
                                foreach ($kelompokPelayanans as $serviceGroup) {
                                    $selectedService = $serviceGroup->jenisPelayanans->firstWhere('id', (int) $selectedServiceId);
                                    if ($selectedService) {
                                        $selectedServiceName = $selectedService->nama_pelayanan;
                                        break;
                                    }
                                }
                            @endphp
                            <div class="service-picker" data-service-picker>
                                <input type="hidden" id="jenis_pelayanan_id" name="jenis_pelayanan_id" value="{{ $selectedServiceId }}">
                                <button type="button" class="service-picker-toggle" data-service-toggle aria-haspopup="listbox" aria-expanded="false">
                                    <span data-service-label>{{ $selectedServiceName }}</span>
                                    <span class="service-picker-chevron" aria-hidden="true">&#9662;</span>
                                </button>
                                <div class="service-picker-menu" role="listbox" aria-label="Pilih jenis layanan">
                                    <button type="button" class="service-picker-option {{ $selectedServiceId === '' ? 'is-selected' : '' }}" data-service-option="" data-service-group="" role="option" aria-selected="{{ $selectedServiceId === '' ? 'true' : 'false' }}">Semua Jenis</button>
                                    @foreach($kelompokPelayanans as $group)
                                        @foreach($group->jenisPelayanans as $jenis)
                                            <button type="button" class="service-picker-option" data-service-option="{{ $jenis->id }}" data-service-group="{{ $group->id }}" role="option" aria-selected="{{ $selectedServiceId === (string) $jenis->id ? 'true' : 'false' }}">{{ $jenis->nama_pelayanan }}</button>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label for="kecamatan_id">Kecamatan</label>
                            @php
                                $selectedKecamatanId = (string) request('kecamatan_id');
                                $selectedKecamatan = $kecamatans->firstWhere('id', (int) $selectedKecamatanId);
                                $selectedKecamatanName = $selectedKecamatan ? $selectedKecamatan->nama_kecamatan : 'Semua Kecamatan';
                            @endphp
                            <div class="service-picker" data-kecamatan-picker>
                                <input type="hidden" id="kecamatan_id" name="kecamatan_id" value="{{ $selectedKecamatanId }}">
                                <button type="button" class="service-picker-toggle" data-kecamatan-toggle aria-haspopup="listbox" aria-expanded="false">
                                    <span data-kecamatan-label>{{ $selectedKecamatanName }}</span>
                                    <span class="service-picker-chevron" aria-hidden="true">&#9662;</span>
                                </button>
                                <div class="service-picker-menu" role="listbox" aria-label="Pilih Kecamatan">
                                    <button type="button" class="service-picker-option {{ $selectedKecamatanId === '' ? 'is-selected' : '' }}" data-kecamatan-option="" role="option" aria-selected="{{ $selectedKecamatanId === '' ? 'true' : 'false' }}">Semua Kecamatan</button>
                                    @foreach($kecamatans as $kecamatan)
                                        <button type="button" class="service-picker-option {{ $selectedKecamatanId === (string) $kecamatan->id ? 'is-selected' : '' }}" data-kecamatan-option="{{ $kecamatan->id }}" role="option" aria-selected="{{ $selectedKecamatanId === (string) $kecamatan->id ? 'true' : 'false' }}">{{ $kecamatan->nama_kecamatan }}</button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label for="desa_id">Desa/Kelurahan</label>
                            @php
                                $selectedDesaId = (string) request('desa_id');
                                $selectedDesa = $desas->firstWhere('id', (int) $selectedDesaId);
                                $selectedDesaName = $selectedDesa ? $selectedDesa->nama_desa : 'Semua Desa/Kelurahan';
                            @endphp
                            <div class="service-picker" data-desa-picker>
                                <input type="hidden" id="desa_id" name="desa_id" value="{{ $selectedDesaId }}">
                                <button type="button" class="service-picker-toggle" data-desa-toggle aria-haspopup="listbox" aria-expanded="false">
                                    <span data-desa-label>{{ $selectedDesaName }}</span>
                                    <span class="service-picker-chevron" aria-hidden="true">&#9662;</span>
                                </button>
                                <div class="service-picker-menu" role="listbox" aria-label="Pilih Desa/Kelurahan">
                                    <div style="padding: 4px; position: sticky; top: -8px; background: #fff; z-index: 5; border-bottom: 1px solid #e2e8f0; margin: -8px -8px 4px -8px;">
                                        <input type="text" data-desa-search placeholder="Cari desa/kelurahan..." style="width:100%; height:32px; padding:0 8px; font-size:11px; border:1px solid #cbd5e1; border-radius:2px; outline:none;" autocomplete="off">
                                    </div>
                                    <div data-desa-list>
                                        <button type="button" class="service-picker-option {{ $selectedDesaId === '' ? 'is-selected' : '' }}" data-desa-option="" data-kecamatan-id="" role="option" aria-selected="{{ $selectedDesaId === '' ? 'true' : 'false' }}">Semua Desa/Kelurahan</button>
                                        @foreach($desas as $desa)
                                            <button type="button" class="service-picker-option {{ $selectedDesaId === (string) $desa->id ? 'is-selected' : '' }}" data-desa-option="{{ $desa->id }}" data-kecamatan-id="{{ $desa->kecamatan_id }}" role="option" aria-selected="{{ $selectedDesaId === (string) $desa->id ? 'true' : 'false' }}">{{ $desa->nama_desa }}</button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="primary-btn">Terapkan Filter</button>
                        <a href="{{ route('permohonan.index') }}" class="btn-secondary">Reset</a>
                    </div>
                </form>
            </div>

            <div class="table-section">
                <div class="table-top">
                    <h3>Daftar Data</h3>
                    <small>Total: {{ $permohonans->count() }} data ditemukan</small>
                </div>

                <div class="table-wrap">
                    <table class="sipper-data-table">
                        <thead>
                            <tr>
                                <th style="width:5%;">No</th>
                                <th style="width:12%;">Tanggal Pengajuan</th>
                                <th style="width:18%;">Nama Pemohon</th>
                                <th style="width:12%;">Kategori Layanan</th>
                                <th style="width:16%;">Jenis Layanan</th>
                                <th style="width:14%;">Kecamatan</th>
                                <th style="width:14%;">Desa/Kelurahan</th>
                                <th style="width:9%;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($permohonans as $i => $permohonan)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $permohonan->tanggal_permohonan?->format('d/m/Y') ?? '-' }}</td>
                                <td>
                                    <div class="applicant-name">{{ $permohonan->nama_pemohon }}</div>
                                    <div class="application-number">{{ $permohonan->nomor_permohonan ?? '-' }}</div>
                                </td>
                                <td>{{ $permohonan->jenisPelayanan?->kelompokPelayanan?->nama ?? '-' }}</td>
                                <td>{{ $permohonan->jenisPelayanan?->nama_pelayanan ?? '-' }}</td>
                                <td>{{ $permohonan->kecamatan?->nama_kecamatan ?? '-' }}</td>
                                <td>{{ $permohonan->desa?->nama_desa ?? '-' }}</td>
                                <td>
                                    <span class="status-badge">Aktif</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty-state">
                                    <div class="empty-icon">◌</div>
                                    <p class="empty-text">Belum ada data permohonan tersimpan</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    // Service Picker Logic
    const serviceCategory = document.querySelector('#kelompok_pelayanan_id');
    const servicePicker = document.querySelector('[data-service-picker]');

    if (serviceCategory && servicePicker) {
        const serviceToggle = servicePicker.querySelector('[data-service-toggle]');
        const serviceInput = servicePicker.querySelector('#jenis_pelayanan_id');
        const serviceLabel = servicePicker.querySelector('[data-service-label]');
        const serviceOptions = [...servicePicker.querySelectorAll('[data-service-option]')];

        const filterServices = () => {
            const categoryId = serviceCategory.value;
            const selectedOption = serviceOptions.find((option) => option.dataset.serviceOption === serviceInput.value);
            const selectedIsValid = selectedOption && (!categoryId || selectedOption.dataset.serviceGroup === categoryId);

            if (!selectedIsValid && serviceInput.value !== '') {
                serviceInput.value = '';
                serviceLabel.textContent = 'Semua Jenis';
            }

            serviceOptions.forEach((option) => {
                const isAll = option.dataset.serviceOption === '';
                option.hidden = !isAll && categoryId !== '' && option.dataset.serviceGroup !== categoryId;
                option.classList.toggle('is-selected', option.dataset.serviceOption === serviceInput.value);
                option.setAttribute('aria-selected', option.dataset.serviceOption === serviceInput.value ? 'true' : 'false');
            });
        };

        serviceToggle.addEventListener('click', () => {
            closeAllPickersExcept(servicePicker);
            const isOpen = servicePicker.classList.toggle('is-open');
            serviceToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        serviceOptions.forEach((option) => {
            option.addEventListener('click', () => {
                serviceInput.value = option.dataset.serviceOption;
                serviceLabel.textContent = option.textContent;
                filterServices();
                servicePicker.classList.remove('is-open');
                serviceToggle.setAttribute('aria-expanded', 'false');
            });
        });

        serviceCategory.addEventListener('change', filterServices);
        filterServices();
    }

    // Kecamatan Picker & Desa Picker Logic
    const kecamatanPicker = document.querySelector('[data-kecamatan-picker]');
    const desaPicker = document.querySelector('[data-desa-picker]');

    const closeAllPickersExcept = (current) => {
        document.querySelectorAll('.service-picker.is-open').forEach(picker => {
            if (picker !== current) {
                picker.classList.remove('is-open');
                const toggle = picker.querySelector('button[aria-expanded]');
                if (toggle) toggle.setAttribute('aria-expanded', 'false');
            }
        });
    };

    if (kecamatanPicker && desaPicker) {
        const kecToggle = kecamatanPicker.querySelector('[data-kecamatan-toggle]');
        const kecInput = kecamatanPicker.querySelector('#kecamatan_id');
        const kecLabel = kecamatanPicker.querySelector('[data-kecamatan-label]');
        const kecOptions = [...kecamatanPicker.querySelectorAll('[data-kecamatan-option]')];

        const desaToggle = desaPicker.querySelector('[data-desa-toggle]');
        const desaInput = desaPicker.querySelector('#desa_id');
        const desaLabel = desaPicker.querySelector('[data-desa-label]');
        const desaSearch = desaPicker.querySelector('[data-desa-search]');
        const desaOptions = [...desaPicker.querySelectorAll('[data-desa-option]')];

        const filterDesaList = () => {
            const selectedKecId = kecInput.value;
            const searchVal = (desaSearch ? desaSearch.value : '').toLowerCase().trim();

            let validSelected = false;

            desaOptions.forEach((option) => {
                const isAll = option.dataset.desaOption === '';
                const matchKec = !selectedKecId || isAll || option.dataset.kecamatanId === selectedKecId;
                const matchSearch = isAll || !searchVal || option.textContent.toLowerCase().includes(searchVal);

                const show = matchKec && matchSearch;
                option.hidden = !show;

                if (option.dataset.desaOption === desaInput.value && show) {
                    validSelected = true;
                }

                option.classList.toggle('is-selected', option.dataset.desaOption === desaInput.value);
                option.setAttribute('aria-selected', option.dataset.desaOption === desaInput.value ? 'true' : 'false');
            });

            if (!validSelected && desaInput.value !== '') {
                desaInput.value = '';
                desaLabel.textContent = 'Semua Desa/Kelurahan';
            }
        };

        // Kecamatan events
        kecToggle.addEventListener('click', () => {
            closeAllPickersExcept(kecamatanPicker);
            const isOpen = kecamatanPicker.classList.toggle('is-open');
            kecToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        kecOptions.forEach(option => {
            option.addEventListener('click', () => {
                kecInput.value = option.dataset.kecamatanOption;
                kecLabel.textContent = option.textContent;
                kecOptions.forEach(o => {
                    o.classList.toggle('is-selected', o === option);
                    o.setAttribute('aria-selected', o === option ? 'true' : 'false');
                });
                kecamatanPicker.classList.remove('is-open');
                kecToggle.setAttribute('aria-expanded', 'false');
                filterDesaList();
            });
        });

        // Desa events
        desaToggle.addEventListener('click', () => {
            closeAllPickersExcept(desaPicker);
            const isOpen = desaPicker.classList.toggle('is-open');
            desaToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            if (isOpen && desaSearch) {
                setTimeout(() => desaSearch.focus(), 50);
            }
        });

        if (desaSearch) {
            desaSearch.addEventListener('input', filterDesaList);
        }

        desaOptions.forEach(option => {
            option.addEventListener('click', () => {
                desaInput.value = option.dataset.desaOption;
                desaLabel.textContent = option.textContent;
                filterDesaList();
                desaPicker.classList.remove('is-open');
                desaToggle.setAttribute('aria-expanded', 'false');
            });
        });

        filterDesaList();
    }

    // Global click listener to close all pickers
    document.addEventListener('click', (event) => {
        if (!event.target.closest('.service-picker')) {
            closeAllPickersExcept(null);
        }
    });
</script>
</body>
</html>

