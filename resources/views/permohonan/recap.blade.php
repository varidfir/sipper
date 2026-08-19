<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rekapitulasi Permohonan - Sistem Rekap</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .recap-page { padding: 18px clamp(16px, 3vw, 32px) 32px; }
        .recap-panel { max-width: 1360px; margin: 0 auto; }
        .recap-title { margin-bottom: 16px; }
        .recap-title h1 { margin: 4px 0 0; color: #0f172a; font-size: 22px; line-height: 1.2; }
        .recap-title p { margin: 5px 0 0; color: #64748b; font-size: 12px; }
        .recap-filter { overflow: hidden; border: 1px solid #dbe3ed; border-radius: 3px; background: #fff; box-shadow: 0 1px 3px rgba(15, 23, 42, .04); }
        .recap-filter-head { padding: 11px 14px; border-bottom: 1px solid #dbe3ed; background: #1d61e8; color: #fff; }
        .recap-filter-head h2 { margin: 0; font-size: 13px; }
        .recap-filter-head p { margin: 2px 0 0; color: #dbeafe; font-size: 11px; }
        .recap-filter-form { display: grid; grid-template-columns: repeat(8, minmax(0, 1fr)); gap: 12px 14px; align-items: end; padding: 14px; }
        .recap-field { min-width: 0; }
        .recap-field label { display: block; margin-bottom: 5px; color: #475569; font-size: 11px; font-weight: 700; }
        .recap-field select { width: 100%; height: 35px; border: 1px solid #cbd5e1; border-radius: 2px; background: #fff; padding: 0 9px; color: #334155; font-size: 12px; }
        .recap-field select:focus { border-color: #60a5fa; outline: 0; box-shadow: 0 0 0 2px rgba(59, 130, 246, .12); }
        .recap-filter-actions { display: flex; gap: 8px; grid-column: span 2; }
        .recap-filter-actions button, .recap-filter-actions a { display: inline-flex; align-items: center; justify-content: center; width: 100%; height: 35px; border-radius: 2px; font-size: 12px; font-weight: 700; text-decoration: none; }
        .recap-filter-actions button { border: 1px solid #1d61e8; background: #1d61e8; color: #fff; cursor: pointer; }
        .recap-filter-actions a { border: 1px solid #cbd5e1; background: #fff; color: #334155; }
        .recap-summary { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin: 16px 0; padding: 12px 14px; border: 1px solid #bfdbfe; border-radius: 3px; background: #eff6ff; }
        .recap-summary-label { color: #1d4ed8; font-size: 10px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; }
        .recap-summary-value { margin-top: 4px; color: #1e3a8a; font-size: 12px; font-weight: 700; }
        .recap-total { min-width: 140px; padding: 7px 12px; border: 1px solid #bfdbfe; border-radius: 2px; background: #fff; text-align: center; }
        .recap-total small { display: block; color: #64748b; font-size: 10px; }
        .recap-total strong { display: block; margin-top: 2px; color: #1d61e8; font-size: 18px; }
        .recap-results { overflow: hidden; border: 1px solid #dbe3ed; border-radius: 3px; background: #fff; box-shadow: 0 1px 3px rgba(15, 23, 42, .04); }
        .recap-results-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 13px 14px; border-bottom: 1px solid #dbe3ed; }
        .recap-results-head h2 { margin: 0; color: #0f172a; font-size: 14px; }
        .recap-results-head p { margin: 3px 0 0; color: #64748b; font-size: 11px; }
        .recap-count { color: #64748b; font-size: 11px; font-weight: 700; white-space: nowrap; }
        .recap-table { width: 100%; border-collapse: collapse; font-size: 12px; }
        .recap-table th { padding: 10px 14px; border-bottom: 1px solid #dbe3ed; background: #eff6ff; color: #1e40af; font-size: 10px; text-align: left; text-transform: uppercase; }
        .recap-table td { padding: 11px 14px; border-bottom: 1px solid #edf2f7; color: #475569; }
        .recap-table tbody tr:hover { background: #f8fbff; }
        .recap-table tbody tr:last-child td { border-bottom: 0; }
        .recap-table .period { color: #1f2937; font-weight: 700; }
        .recap-number { display: inline-flex; min-width: 70px; justify-content: center; padding: 4px 8px; border: 1px solid #bfdbfe; border-radius: 2px; background: #eff6ff; color: #1d4ed8; font-weight: 700; }
        .recap-table tfoot { background: #f8fafc; }
        .recap-table tfoot td { border-top: 1px solid #dbe3ed; color: #334155; font-weight: 800; }
        .recap-empty { padding: 42px 16px; text-align: center; }
        .recap-empty strong { display: block; color: #334155; font-size: 13px; }
        .recap-empty p { margin: 5px 0 14px; color: #64748b; font-size: 12px; }
        .recap-export { display: flex; justify-content: flex-end; gap: 8px; margin-top: 14px; }
        .recap-export a, .recap-export button { height: 35px; padding: 0 14px; border-radius: 2px; font-size: 12px; font-weight: 700; }
        .recap-export a { display: inline-flex; align-items: center; background: #1d61e8; color: #fff; text-decoration: none; }
        .recap-export button { border: 1px solid #cbd5e1; background: #fff; color: #334155; cursor: pointer; }
        @media (max-width: 900px) { .recap-filter-form { grid-template-columns: repeat(4, minmax(0, 1fr)); } .recap-filter-actions { grid-column: span 2; } }
        @media (max-width: 600px) { .recap-filter-form { grid-template-columns: 1fr 1fr; } .recap-filter-actions { grid-column: span 2; } .recap-summary { align-items: flex-start; flex-direction: column; } .recap-total { width: 100%; } .recap-results { overflow-x: auto; } .recap-table { min-width: 520px; } .recap-export { justify-content: stretch; } .recap-export a, .recap-export button { flex: 1; text-align: center; } }
    </style>
</head>

<body class="min-h-screen overflow-x-hidden bg-slate-100 text-slate-800">

    {{-- =========================================================
        SIDEBAR
    ========================================================== --}}
    @include('layouts.sidebar')


    {{-- =========================================================
        KONTEN UTAMA
    ========================================================== --}}
    <main class="sipper-content">
        @include('layouts.header', ['pageTitle' => 'Rekapitulasi'])

        <div class="recap-page">

            <div class="recap-panel">
                <div class="recap-title">
                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-blue-600">Laporan pelayanan</p>
                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">Rekapitulasi</h1>
                    <p class="mt-1 text-sm text-slate-500">Ringkasan permohonan berdasarkan periode dan kategori.</p>
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
                    <div class="recap-field">

                        <label class="mb-1 block text-xs font-bold text-slate-600">
                            Periode
                        </label>

                        <select
                            name="period"
                            class="h-10 w-full rounded-lg border border-slate-300 bg-white px-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        >

                            <option
                                value="daily"
                                {{ ($period ?? 'daily') === 'daily' ? 'selected' : '' }}
                            >
                                Harian
                            </option>

                            <option
                                value="monthly"
                                {{ ($period ?? '') === 'monthly' ? 'selected' : '' }}
                            >
                                Bulanan
                            </option>

                            <option
                                value="yearly"
                                {{ ($period ?? '') === 'yearly' ? 'selected' : '' }}
                            >
                                Tahunan
                            </option>

                        </select>

                    </div>



                    {{-- TAHUN --}}
                    <div class="recap-field">

                        <label class="mb-1 block text-xs font-bold text-slate-600">
                            Tahun
                        </label>

                        <select
                            name="year"
                            class="h-10 w-full rounded-lg border border-slate-300 bg-white px-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        >

                            @for($y = now()->year; $y >= now()->year - 5; $y--)

                                <option
                                    value="{{ $y }}"
                                    {{ (int)($year ?? now()->year) === $y ? 'selected' : '' }}
                                >
                                    {{ $y }}
                                </option>

                            @endfor

                        </select>

                    </div>



                    {{-- BULAN --}}
                    <div class="recap-field">

                        <label class="mb-1 block text-xs font-bold text-slate-600">
                            Bulan
                        </label>

                        <select
                            name="month"
                            class="h-10 w-full rounded-lg border border-slate-300 bg-white px-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        >

                            <option value="">
                                Semua Bulan
                            </option>

                            @foreach($months as $number => $name)

                                <option
                                    value="{{ $number }}"
                                    {{ (string)($month ?? '') === (string)$number ? 'selected' : '' }}
                                >
                                    {{ $name }}
                                </option>

                            @endforeach

                        </select>

                    </div>



                    {{-- KATEGORI --}}
                    <div class="recap-field" style="grid-column: span 2;">

                        <label class="mb-1 block text-xs font-bold text-slate-600">
                            Kategori Permohonan
                        </label>

                        <select
                            name="kelompok_pelayanan_id"
                            class="h-10 w-full rounded-lg border border-slate-300 bg-white px-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        >

                            <option value="">
                                Semua Kategori
                            </option>

                            @foreach($kelompokPelayanans as $kelompok)

                                <option
                                    value="{{ $kelompok->id }}"
                                    {{ (string)($kelompokPelayananId ?? '') === (string)$kelompok->id ? 'selected' : '' }}
                                >
                                    {{ $kelompok->kode === 'SURAT_PINDAH'
                                        ? 'SURAT PINDAH'
                                        : $kelompok->kode }}
                                </option>

                            @endforeach

                        </select>

                    </div>



                    {{-- BUTTON --}}
                    <div class="recap-filter-actions">

                        <button
                            type="submit"
                            class="h-10 flex-1 rounded-lg bg-blue-600 px-4 text-sm font-bold text-white transition hover:bg-blue-700"
                        >
                            Filter
                        </button>

                        <a
                            href="{{ route('permohonan.recap') }}"
                            class="h-10 flex-1 rounded-lg border border-slate-300 bg-white px-4 text-sm font-bold text-slate-700 transition hover:bg-slate-50"
                        >
                            Reset
                        </a>

                    </div>

                </form>
            </div>



            {{-- =====================================================
                RINGKASAN FILTER AKTIF
            ====================================================== --}}
            <div class="recap-summary mb-4 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 sm:px-5">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="recap-summary-label text-xs font-bold uppercase tracking-wider text-blue-600">
                            Filter Aktif
                        </p>

                        <p class="recap-summary-value mt-1 text-sm font-semibold text-slate-800">

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

                        </p>

                    </div>


                    {{-- TOTAL --}}
                    <div class="recap-total min-w-[150px] rounded-lg border border-blue-100 bg-white px-4 py-2 text-center shadow-sm">

                        <small class="text-xs text-slate-500">
                            Total Permohonan
                        </small>

                        <strong class="text-xl font-bold text-blue-600">
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


                        <span class="recap-count text-sm font-semibold text-slate-500">
                            {{ $data->count() }} periode
                        </span>

                    </div>

                </div>



                {{-- =================================================
                    DATA ADA
                ================================================== --}}
                @if($data->count())

                    <div class="overflow-x-auto">

                        <table class="recap-table w-full text-sm">

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


                            <tbody class="divide-y divide-slate-100">

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
                                            {{ $data->sum('total') }}
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
                    ]) }}"
                    class="inline-flex h-10 items-center rounded-lg bg-emerald-600 px-4 text-sm font-semibold text-white transition hover:bg-emerald-700"
                >
                    Unduh PDF
                </a>

                <button
                    type="button"
                    onclick="window.print()"
                    class="inline-flex h-10 items-center rounded-lg border border-slate-300 bg-white px-4 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Cetak Rekap
                </button>

            </div>


            </div>
        </div>

    </main>

</body>

<style>
    @media print {
        @page { margin: 14mm; }
        body { background: #fff !important; }
        .sipper-sidebar,
        .topbar { display: none !important; }
        .sipper-content { width: 100% !important; margin-left: 0 !important; }
        .sipper-content > div { padding: 0 !important; }
        .shadow-sm { box-shadow: none !important; }
        .rounded-xl { border-radius: 0 !important; }
    }
</style>

</html>