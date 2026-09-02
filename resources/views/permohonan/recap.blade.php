<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rekapitulasi Permohonan - Sistem Rekap</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .recap-page {
            padding: 10px clamp(12px, 3vw, 20px) 16px;
        }

        .recap-panel {
            max-width: 1360px;
            margin: 0 auto;
        }

        .recap-title {
            margin-bottom: 6px;
        }

        .recap-title h1 {
            margin: 2px 0 0;
            color: #0f172a;
            font-size: 18px;
            line-height: 1.2;
        }

        .recap-title p {
            margin: 2px 0 0;
            color: #64748b;
            font-size: 11px;
        }

        .recap-filter {
            overflow: visible;
            border: 1px solid #dbe3ed;
            border-radius: 4px;
            background: #fff;
            box-shadow: 0 1px 3px rgba(15, 23, 42, .04);
            margin-bottom: 8px;
        }

        .recap-filter-head {
            padding: 6px 12px;
            border-bottom: 1px solid #dbe3ed;
            background: var(--sip-sidebar-bg, #0d3969);
            color: #fff;
            border-radius: 3px 3px 0 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .recap-filter-head h2 {
            margin: 0;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: .02em;
        }

        .recap-filter-head p {
            margin: 0;
            color: rgba(255, 255, 255, 0.75);
            font-size: 10px;
        }

        .recap-filter-form {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 6px 8px;
            align-items: end;
            padding: 8px 10px 10px;
        }

        .recap-field {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .recap-field-period { grid-column: span 2; }
        .recap-field-year { grid-column: span 1; }
        .recap-field-month { grid-column: span 2; }
        .recap-field-category { grid-column: span 2; }
        .recap-field-service { grid-column: span 3; }

        .recap-field label {
            display: block;
            margin: 0;
            color: #475569;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .02em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .recap-field select,
        .recap-service-toggle {
            width: 100%;
            height: 32px;
            border: 1px solid #cbd5e1;
            border-radius: 3px;
            background-color: #fff;
            color: #1e293b;
            font-size: 11px;
            font-weight: 500;
            padding: 0 8px;
            outline: none;
            box-sizing: border-box;
            transition: border-color .15s, box-shadow .15s;
        }

        .recap-field select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23475569'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 6px center;
            background-size: 11px 11px;
            padding-right: 22px;
            cursor: pointer;
        }

        .recap-field select:focus,
        .recap-service-toggle:focus,
        .recap-service-picker.is-open .recap-service-toggle {
            border-color: var(--sip-primary, #1d61e8);
            outline: 0;
            box-shadow: 0 0 0 2px rgba(29, 97, 232, .15);
        }

        .recap-service-picker {
            position: relative;
            width: 100%;
        }

        .recap-service-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 4px;
            cursor: pointer;
            text-align: left;
        }

        .recap-service-toggle > span:first-child {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }

        .recap-service-chevron {
            flex: 0 0 auto;
            width: 5px;
            height: 5px;
            border-right: 1.5px solid #475569;
            border-bottom: 1.5px solid #475569;
            font-size: 0;
            transform: rotate(45deg) translate(-1px, -1px);
            transition: transform .15s;
        }

        .recap-service-picker.is-open .recap-service-chevron {
            transform: rotate(225deg) translate(-1px, -1px);
        }

        .recap-service-menu {
            position: absolute;
            z-index: 50;
            top: calc(100% + 3px);
            left: 0;
            width: 100%;
            min-width: 220px;
            max-height: 180px;
            overflow-y: auto;
            padding: 4px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            background: #fff;
            box-shadow: 0 10px 22px rgba(15, 23, 42, .14);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translateY(-4px);
            transition: opacity .15s ease, transform .15s ease, visibility 0s linear .15s;
        }

        .recap-service-picker.is-open .recap-service-menu {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateY(0);
            transition-delay: 0s;
        }

        .recap-service-option {
            width: 100%;
            min-height: 25px;
            border: 1px solid transparent;
            border-radius: 3px;
            background: transparent;
            color: #334155;
            padding: 3px 6px;
            font-size: 10.5px;
            line-height: 1.3;
            white-space: normal;
            overflow-wrap: anywhere;
            text-align: left;
            cursor: pointer;
            transition: background .12s, color .12s;
        }

        .recap-service-option:hover,
        .recap-service-option.is-selected {
            border-color: var(--sip-primary, #1d61e8);
            background: rgba(29, 97, 232, .08);
            color: var(--sip-primary, #1d61e8);
            font-weight: 700;
        }

        .recap-service-option[hidden] {
            display: none !important;
        }

        .recap-service-menu::-webkit-scrollbar {
            width: 5px;
        }

        .recap-service-menu::-webkit-scrollbar-thumb {
            border-radius: 4px;
            background: #cbd5e1;
        }

        .recap-filter-actions {
            display: flex;
            gap: 5px;
            grid-column: span 2;
        }

        .recap-filter-actions button,
        .recap-filter-actions a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 32px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            box-sizing: border-box;
            transition: background .15s, border-color .15s, color .15s;
        }

        .recap-filter-actions button {
            flex: 1.2;
            border: 1px solid var(--sip-primary, #1d61e8);
            background: var(--sip-primary, #1d61e8);
            color: #fff;
        }

        .recap-filter-actions button:hover {
            background: var(--sip-primary-hover, #1752ca);
        }

        .recap-filter-actions a {
            flex: 0.8;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            color: #475569;
        }

        .recap-filter-actions a:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .recap-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin: 6px 0 10px;
            padding: 6px 12px;
            border: 1px solid #bfdbfe;
            border-radius: 4px;
            background: #eff6ff;
        }

        .recap-summary-label {
            color: #1d4ed8;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .recap-summary-value {
            margin-top: 2px;
            color: #1e3a8a;
            font-size: 11px;
            font-weight: 700;
        }

        .recap-total {
            min-width: 120px;
            padding: 5px 10px;
            border: 1px solid #bfdbfe;
            border-radius: 2px;
            background: #fff;
            text-align: center;
        }

        .recap-total small {
            display: block;
            color: #64748b;
            font-size: 9px;
        }

        .recap-total strong {
            display: block;
            margin-top: 1px;
            color: #1d61e8;
            font-size: 16px;
        }

        .recap-results {
            overflow: hidden;
            border: 1px solid #dbe3ed;
            border-radius: 3px;
            background: #fff;
            box-shadow: 0 1px 3px rgba(15, 23, 42, .04);
        }

        .recap-results-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 8px 10px;
            border-bottom: 1px solid #dbe3ed;
        }

        .recap-results-head h2 {
            margin: 0;
            color: #0f172a;
            font-size: 12px;
        }

        .recap-results-head p {
            margin: 1px 0 0;
            color: #64748b;
            font-size: 10px;
        }

        .recap-count {
            color: #64748b;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .recap-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        .recap-table th {
            padding: 7px 10px;
            border-bottom: 1px solid #dbe3ed;
            background: #eff6ff;
            color: #1e40af;
            font-size: 9px;
            text-align: left;
            text-transform: uppercase;
        }

        .recap-table td {
            padding: 7px 10px;
            border-bottom: 1px solid #edf2f7;
            color: #475569;
        }

        .recap-table tbody tr:hover {
            background: #f8fbff;
        }

        .recap-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .recap-table .period {
            color: #1f2937;
            font-weight: 700;
        }

        .recap-number {
            display: inline-flex;
            min-width: 60px;
            justify-content: center;
            padding: 3px 6px;
            border: 1px solid #bfdbfe;
            border-radius: 2px;
            background: #eff6ff;
            color: #1d4ed8;
            font-weight: 700;
        }

        .recap-table tfoot {
            background: #f8fafc;
        }

        .recap-table tfoot td {
            border-top: 1px solid #dbe3ed;
            color: #334155;
            font-weight: 800;
        }

        .recap-empty {
            padding: 30px 12px;
            text-align: center;
        }

        .recap-empty strong {
            display: block;
            color: #334155;
            font-size: 12px;
        }

        .recap-empty p {
            margin: 3px 0 10px;
            color: #64748b;
            font-size: 11px;
        }

        .recap-export {
            display: flex;
            justify-content: flex-end;
            gap: 6px;
            margin-top: 8px;
        }

        .recap-export a,
        .recap-export button {
            height: 32px;
            padding: 0 12px;
            border-radius: 2px;
            font-size: 11px;
            font-weight: 700;
        }

        .recap-export a {
            display: inline-flex;
            align-items: center;
            background: #1d61e8;
            color: #fff;
            text-decoration: none;
        }

        .recap-export button {
            border: 1px solid #cbd5e1;
            background: #fff;
            color: #334155;
            cursor: pointer;
        }

        .recap-filter-head {
            background: var(--sip-sidebar-bg);
        }

        .recap-filter-head p {
            color: var(--sip-sidebar-text);
        }

        .recap-field select:focus {
            border-color: var(--sip-primary);
            box-shadow: 0 0 0 2px rgba(29, 97, 232, .12);
        }

        .recap-filter-actions button,
        .recap-export a {
            border-color: var(--sip-primary);
            background: var(--sip-primary);
        }

        .recap-filter-actions button:hover,
        .recap-export a:hover {
            background: var(--sip-primary-hover);
        }

        .recap-summary {
            border-color: var(--sip-primary-border);
            background: var(--sip-primary-soft);
        }

        .recap-summary-label,
        .recap-total strong,
        .recap-number {
            color: var(--sip-primary);
        }

        .recap-summary-value {
            color: var(--sip-sidebar-bg);
        }

        .recap-total,
        .recap-number {
            border-color: var(--sip-primary-border);
        }

        .recap-table th {
            background: var(--sip-primary-soft);
            color: var(--sip-primary-hover);
        }

        .recap-table tbody tr:hover {
            background: #f4f8ff;
        }

        .recap-number {
            background: var(--sip-primary-soft);
        }

        @media (max-width: 1024px) {
            .recap-filter-form {
                grid-template-columns: repeat(6, minmax(0, 1fr));
            }

            .recap-field-period { grid-column: span 2; }
            .recap-field-year { grid-column: span 2; }
            .recap-field-month { grid-column: span 2; }
            .recap-field-category { grid-column: span 2; }
            .recap-field-service { grid-column: span 2; }
            .recap-filter-actions { grid-column: span 2; }
        }

        @media (max-width: 640px) {
            .recap-filter-form {
                grid-template-columns: 1fr 1fr;
            }

            .recap-field-period { grid-column: span 1; }
            .recap-field-year { grid-column: span 1; }
            .recap-field-month { grid-column: span 1; }
            .recap-field-category { grid-column: span 1; }
            .recap-field-service { grid-column: span 2; }
            .recap-filter-actions { grid-column: span 2; }

            .recap-summary {
                align-items: flex-start;
                flex-direction: column;
            }

            .recap-total {
                width: 100%;
            }

            .recap-results {
                overflow-x: auto;
            }

            .recap-table {
                min-width: 520px;
            }
        }
    </style>
</head>

<body data-recap-page class="min-h-screen overflow-x-hidden bg-slate-100 text-slate-800">

    {{-- =========================================================
        SIDEBAR
    ========================================================== --}}
    @include('layouts.sidebar')

    {{-- =========================================================
        KONTEN UTAMA
    ========================================================== --}}
    <main class="sipper-content">

        @include('layouts.header', ['pageTitle' => 'Rekapitulasi'])

        <div class="page-shell">

            <div class="form-page-container">

                <div class="form-header">
                    <div class="form-title-group">
                        <h1>Rekapitulasi</h1>
                        <p>Ringkasan permohonan berdasarkan periode dan kategori.</p>
                    </div>
                </div>

                {{-- =====================================================
                    FILTER REKAP
                ====================================================== --}}
                <div class="recap-filter">

                    <div class="recap-filter-head">
                        <h2>Filter Data</h2>
                        <p>Pilih periode dan kategori yang ingin ditampilkan.</p>
                    </div>

                    <form
                        method="GET"
                        action="{{ route('permohonan.recap') }}"
                        class="recap-filter-form"
                    >

                        {{-- PERIODE --}}
                        <div class="recap-field recap-field-period">
                            <label for="period_select">Periode</label>
                            <select id="period_select" name="period">
                                <option value="daily" {{ ($period ?? 'daily') === 'daily' ? 'selected' : '' }}>Harian</option>
                                <option value="monthly" {{ ($period ?? '') === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                                <option value="yearly" {{ ($period ?? '') === 'yearly' ? 'selected' : '' }}>Tahunan</option>
                            </select>
                        </div>

                        {{-- TAHUN --}}
                        <div class="recap-field recap-field-year">
                            <label for="year_select">Tahun</label>
                            <select id="year_select" name="year">
                                @for($y = now()->year; $y >= now()->year - 5; $y--)
                                    <option value="{{ $y }}" {{ (int)($year ?? now()->year) === $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>

                        {{-- BULAN --}}
                        <div class="recap-field recap-field-month">
                            <label for="month_select">Bulan</label>
                            <select id="month_select" name="month">
                                <option value="">Semua Bulan</option>
                                @foreach($months as $number => $name)
                                    <option value="{{ $number }}" {{ (string)($month ?? '') === (string)$number ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- KATEGORI --}}
                        <div class="recap-field recap-field-category">
                            <label for="kelompok_select">Kategori</label>
                            <select id="kelompok_select" name="kelompok_pelayanan_id">
                                <option value="">Semua Kategori</option>
                                @foreach($kelompokPelayanans as $kelompok)
                                    <option value="{{ $kelompok->id }}" {{ (string)($kelompokPelayananId ?? '') === (string)$kelompok->id ? 'selected' : '' }}>
                                        {{ $kelompok->kode === 'SURAT_PINDAH' ? 'SURAT PINDAH' : $kelompok->kode }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- JENIS LAYANAN --}}
                        <div class="recap-field recap-field-service">
                            <label for="jenis_service_input">Jenis Layanan</label>
                            @php
                                $selectedServiceId = (string) ($jenisPelayananId ?? '');
                                $selectedServiceName = 'Semua Jenis';
                                if ($selectedServiceId !== '') {
                                    foreach ($kelompokPelayanans as $serviceGroup) {
                                        $found = $serviceGroup->jenisPelayanans->firstWhere('id', (int) $selectedServiceId);
                                        if ($found) {
                                            $selectedServiceName = $found->nama_pelayanan;
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            <div class="recap-service-picker" data-recap-service-picker>
                                <input type="hidden" id="jenis_service_input" name="jenis_pelayanan_id" value="{{ $selectedServiceId }}">
                                <button type="button" class="recap-service-toggle" data-recap-service-toggle aria-haspopup="listbox" aria-expanded="false">
                                    <span data-recap-service-label>{{ $selectedServiceName }}</span>
                                    <span class="recap-service-chevron" aria-hidden="true">&#9662;</span>
                                </button>
                                <div class="recap-service-menu" role="listbox" aria-label="Pilih jenis layanan">
                                    <button type="button" class="recap-service-option {{ $selectedServiceId === '' ? 'is-selected' : '' }}" data-recap-service-option="" data-recap-service-group="" role="option" aria-selected="{{ $selectedServiceId === '' ? 'true' : 'false' }}">Semua Jenis</button>
                                    @foreach($kelompokPelayanans as $group)
                                        @foreach($group->jenisPelayanans as $jenis)
                                            <button type="button" class="recap-service-option {{ $selectedServiceId === (string) $jenis->id ? 'is-selected' : '' }}" data-recap-service-option="{{ $jenis->id }}" data-recap-service-group="{{ $group->id }}" role="option" aria-selected="{{ $selectedServiceId === (string) $jenis->id ? 'true' : 'false' }}">{{ $jenis->nama_pelayanan }}</button>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- BUTTON --}}
                        <div class="recap-filter-actions">
                            <button type="submit">Filter</button>
                            <a href="{{ route('permohonan.recap') }}">Reset</a>
                        </div>

                    </form>

                </div>

                {{-- =====================================================
                    RINGKASAN FILTER AKTIF
                ====================================================== --}}
                <div class="recap-summary mb-3 rounded-lg border border-blue-100 bg-blue-50 px-3 py-2 sm:px-4">

                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <p class="recap-summary-label text-xs font-bold uppercase tracking-wider text-blue-600">
                                Filter Aktif
                            </p>

                            <p class="recap-summary-value mt-0.5 text-xs font-semibold text-slate-800">

                                Tahun {{ $year }}

                                @if($month)

                                    • {{ $months[(int)$month] }}

                                @else

                                    • Semua Bulan

                                @endif

                                @if($kelompokPelayananId)

                                    @php
                                        $selectedKelompok = $kelompokPelayanans->firstWhere(
                                            'id',
                                            $kelompokPelayananId
                                        );
                                    @endphp

                                    • {{ $selectedKelompok?->kode ?? 'Kategori' }}

                                @else

                                    • Semua Kategori

                                @endif

                                @if($jenisPelayananId)
                                    @php
                                        $selectedJenis = $kelompokPelayanans
                                            ->flatMap->jenisPelayanans
                                            ->firstWhere('id', $jenisPelayananId);
                                    @endphp

                                    • {{ $selectedJenis?->nama_pelayanan ?? 'Jenis Layanan' }}
                                @endif

                            </p>

                        </div>

                        {{-- TOTAL --}}
                        <div class="recap-total min-w-[150px] rounded-lg border border-blue-100 bg-white px-4 py-2 text-center shadow-sm">

                            <small class="text-xs text-slate-500">
                                Total Permohonan
                            </small>

                                <strong class="text-xl font-bold text-blue-600" data-recap-total>
                                {{ $data->sum('total') }}
                            </strong>

                        </div>

                    </div>

                </div>

                {{-- =====================================================
                    HASIL REKAP
                ====================================================== --}}
                <div class="recap-results overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                    {{-- HEADER TABEL --}}
                    <div class="recap-results-head border-b border-slate-200 px-4 py-4 sm:px-5">

                        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

                            <div>

                                <h2 class="font-bold text-slate-900">
                                    Hasil Rekapitulasi
                                </h2>

                                <p class="recap-results-description text-xs text-slate-500">
                                    Data permohonan sesuai filter yang dipilih.
                                </p>

                            </div>

                                <span class="recap-count text-sm font-semibold text-slate-500" data-recap-count>
                                {{ $data->count() }} periode
                            </span>

                        </div>

                    </div>

                    {{-- =================================================
                        DATA ADA
                    ================================================== --}}
                    @if($data->count())

                        <div class="overflow-x-auto">

                            <table class="recap-table sipper-data-table w-full text-sm">

                                <thead class="bg-slate-50">

                                    <tr class="border-b border-slate-200">

                                        <th class="w-16 px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500 sm:px-5">
                                            No
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500 sm:px-5">
                                            Periode
                                        </th>

                                        <th class="px-4 py-3 text-right text-xs font-bold uppercase tracking-wide text-slate-500 sm:px-5">
                                            Jumlah Permohonan
                                        </th>

                                    </tr>

                                </thead>

                                <tbody class="divide-y divide-slate-100" data-recap-body>

                                    @foreach($data as $index => $item)

                                        <tr class="transition hover:bg-slate-50">

                                            {{-- NO --}}
                                            <td class="px-4 py-3 text-slate-500 sm:px-5">
                                                {{ $index + 1 }}
                                            </td>

                                            {{-- PERIODE --}}
                                            <td class="period px-4 py-3 font-semibold text-slate-800 sm:px-5">

                                                @php
                                                    $tanggal = \Carbon\Carbon::parse($item->period);
                                                @endphp

                                                @if($period === 'yearly')

                                                    {{ $tanggal->format('Y') }}

                                                @elseif($period === 'monthly')

                                                    {{ $tanggal->translatedFormat('F Y') }}

                                                @else

                                                    {{ $tanggal->translatedFormat('d F Y') }}

                                                @endif

                                            </td>

                                            {{-- TOTAL --}}
                                            <td class="px-4 py-3 text-right sm:px-5">

                                                <span class="recap-number inline-flex min-w-[80px] justify-center rounded-lg bg-blue-50 px-3 py-1.5 font-bold text-blue-700">
                                                    {{ $item->total }}
                                                </span>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                                {{-- TOTAL --}}
                                <tfoot class="border-t border-slate-200 bg-slate-50">

                                    <tr>

                                        <td
                                            colspan="2"
                                            class="px-4 py-4 text-right font-bold text-slate-700 sm:px-5"
                                        >
                                            Total
                                        </td>

                                        <td class="px-4 py-4 text-right sm:px-5">

                                            <span class="inline-flex min-w-[80px] justify-center rounded-lg bg-blue-600 px-3 py-1.5 font-bold text-white">
                                                <span data-recap-total>{{ $data->sum('total') }}</span>
                                            </span>

                                        </td>

                                    </tr>

                                </tfoot>

                            </table>

                        </div>

                    {{-- =================================================
                        DATA KOSONG
                    ================================================== --}}
                    @else

                        <div class="recap-empty px-5 py-12 text-center">

                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-2xl text-slate-400">
                                ▤
                            </div>

                            <strong class="mt-4 font-bold text-slate-800">
                                Tidak ada data
                            </strong>

                            <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                                Tidak ditemukan permohonan berdasarkan filter yang dipilih.
                            </p>

                            <a
                                href="{{ route('permohonan.recap') }}"
                                class="mt-4 inline-flex rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                            >
                                Reset Filter
                            </a>

                        </div>

                    @endif

                </div>

                {{-- =====================================================
                    EXPORT
                ====================================================== --}}
                <div class="recap-export mt-4 flex flex-wrap justify-end gap-2 print:hidden">

                    <a
                        href="{{ route('permohonan.export', [
                            'year' => $year,
                            'month' => $month,
                            'period' => $period,
                            'kelompok_pelayanan_id' => $kelompokPelayananId,
                            'jenis_pelayanan_id' => $jenisPelayananId,
                        ]) }}"
                        class="inline-flex h-10 items-center rounded-lg bg-emerald-600 px-4 text-sm font-semibold text-white transition hover:bg-emerald-700"
                    >
                        Unduh PDF
                    </a>

                    <a
                        href="{{ route('permohonan.export', [
                            'year' => $year,
                            'month' => $month,
                            'period' => $period,
                            'kelompok_pelayanan_id' => $kelompokPelayananId,
                            'jenis_pelayanan_id' => $jenisPelayananId,
                            'print' => 1,
                        ]) }}"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex h-10 items-center rounded-lg border border-slate-300 bg-white px-4 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Cetak PDF
                    </a>

                </div>

            </div>

        </div>

    </main>

    <script>
        const recapCategory = document.querySelector('select[name="kelompok_pelayanan_id"]');
        const recapServicePicker = document.querySelector('[data-recap-service-picker]');

        if (recapCategory && recapServicePicker) {
            const serviceToggle = recapServicePicker.querySelector('[data-recap-service-toggle]');
            const serviceInput = recapServicePicker.querySelector('input[name="jenis_pelayanan_id"]');
            const serviceLabel = recapServicePicker.querySelector('[data-recap-service-label]');
            const serviceOptions = [...recapServicePicker.querySelectorAll('[data-recap-service-option]')];

            const filterRecapServices = () => {
                const categoryId = recapCategory.value;
                const selectedOption = serviceOptions.find((option) => option.dataset.recapServiceOption === serviceInput.value);
                const selectedIsValid = selectedOption && (!categoryId || selectedOption.dataset.recapServiceGroup === categoryId);

                if (!selectedIsValid && serviceInput.value !== '') {
                    serviceInput.value = '';
                    serviceLabel.textContent = 'Semua Jenis';
                }

                serviceOptions.forEach((option) => {
                    const isAll = option.dataset.recapServiceOption === '';
                    option.hidden = !isAll && categoryId !== '' && option.dataset.recapServiceGroup !== categoryId;
                    option.classList.toggle('is-selected', option.dataset.recapServiceOption === serviceInput.value);
                    option.setAttribute('aria-selected', option.dataset.recapServiceOption === serviceInput.value ? 'true' : 'false');
                });
            };

            serviceToggle.addEventListener('click', () => {
                const isOpen = recapServicePicker.classList.toggle('is-open');
                serviceToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });

            serviceOptions.forEach((option) => {
                option.addEventListener('click', () => {
                    serviceInput.value = option.dataset.recapServiceOption;
                    serviceLabel.textContent = option.textContent;
                    filterRecapServices();
                    recapServicePicker.classList.remove('is-open');
                    serviceToggle.setAttribute('aria-expanded', 'false');
                });
            });

            recapCategory.addEventListener('change', filterRecapServices);
            document.addEventListener('click', (event) => {
                if (!recapServicePicker.contains(event.target)) {
                    recapServicePicker.classList.remove('is-open');
                    serviceToggle.setAttribute('aria-expanded', 'false');
                }
            });
            filterRecapServices();
        }
    </script>

</body>

<style>
    @media print {
        @page {
            margin: 14mm;
        }

        body {
            background: #fff !important;
        }

        .sipper-sidebar,
        .topbar {
            display: none !important;
        }

        .sipper-content {
            width: 100% !important;
            margin-left: 0 !important;
        }

        .sipper-content > div {
            padding: 0 !important;
        }

        .shadow-sm {
            box-shadow: none !important;
        }

        .rounded-xl {
            border-radius: 0 !important;
        }
    }
</style>

</html>