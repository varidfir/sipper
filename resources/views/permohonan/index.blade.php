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
            overflow: hidden;
        }

        .filter-head {
            padding: 18px 20px 8px;
        }

        .filter-head h2 {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            color: #1f2937;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px 18px;
            padding: 16px 20px 20px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .field.wide { grid-column: span 2; }

        .field label {
            font-size: 12px;
            font-weight: 600;
            color: #475467;
        }

        .field input,
        .field select {
            width: 100%;
            min-height: 36px;
            border: 1px solid var(--line-strong);
            border-radius: 10px;
            background: #fff;
            color: var(--text);
            padding: 8px 12px;
            font-size: 13px;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        .field input:focus,
        .field select:focus {
            border-color: var(--sip-primary);
            box-shadow: 0 0 0 3px rgba(29, 97, 232, .12);
        }

        .filter-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 20px 18px;
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
                            <select id="jenis_pelayanan_id" name="jenis_pelayanan_id">
                                <option value="">Semua Jenis</option>
                                @foreach($kelompokPelayanans as $group)
                                    <optgroup label="{{ $group->nama }}">
                                        @foreach($group->jenisPelayanans as $jenis)
                                            <option value="{{ $jenis->id }}" {{ request('jenis_pelayanan_id') == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama_pelayanan }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label for="kecamatan_id">Kecamatan</label>
                            <select id="kecamatan_id" name="kecamatan_id">
                                <option value="">Semua Kecamatan</option>
                                @foreach($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->id }}" {{ request('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label for="desa_id">Desa/Kelurahan</label>
                            <select id="desa_id" name="desa_id">
                                <option value="">Semua Desa/Kelurahan</option>
                                @foreach($desas as $desa)
                                    <option value="{{ $desa->id }}" {{ request('desa_id') == $desa->id ? 'selected' : '' }}>{{ $desa->nama_desa }}</option>
                                @endforeach
                            </select>
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
</body>
</html>

