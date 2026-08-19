<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rekapitulasi Permohonan - Sistem Rekap</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

        <div class="min-h-screen px-4 py-5 sm:px-6 lg:px-8">

            <div class="w-full">
                <div class="mb-5">
                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-blue-600">Laporan pelayanan</p>
                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">Rekapitulasi</h1>
                    <p class="mt-1 text-sm text-slate-500">Ringkasan permohonan berdasarkan periode dan kategori.</p>
                </div>

            {{-- =====================================================
                FILTER REKAP
            ====================================================== --}}
            <div class="mb-4 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-4 py-3 sm:px-5">
                    <h2 class="text-sm font-bold text-slate-800">Filter data</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Pilih rentang waktu dan kategori yang ingin ditampilkan.</p>
                </div>

                <form
                    method="GET"
                    action="{{ route('permohonan.recap') }}"
                    class="grid grid-cols-1 gap-3 p-4 sm:grid-cols-2 xl:grid-cols-12 xl:items-end sm:px-5 sm:py-4"
                >

                    {{-- PERIODE --}}
                    <div class="w-full xl:col-span-2">

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
                    <div class="w-full xl:col-span-2">

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
                    <div class="w-full xl:col-span-2">

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
                    <div class="w-full xl:col-span-4">

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
                    <div class="flex gap-2 xl:col-span-2">

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

                </form>
            </div>



            {{-- =====================================================
                RINGKASAN FILTER AKTIF
            ====================================================== --}}
            <div class="mb-4 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 sm:px-5">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-xs font-bold uppercase tracking-wider text-blue-600">
                            Filter Aktif
                        </p>

                        <p class="mt-1 text-sm font-semibold text-slate-800">

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
                    <div class="min-w-[150px] rounded-lg border border-blue-100 bg-white px-4 py-2 text-center shadow-sm">

                        <p class="text-xs text-slate-500">
                            Total Permohonan
                        </p>

                        <p class="text-xl font-bold text-blue-600">
                            {{ $data->sum('total') }}
                        </p>

                    </div>

                </div>

            </div>



            {{-- =====================================================
                HASIL REKAP
            ====================================================== --}}
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">


                {{-- HEADER TABEL --}}
                <div class="border-b border-slate-200 px-4 py-4 sm:px-5">

                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <h2 class="font-bold text-slate-900">
                                Hasil Rekapitulasi
                            </h2>

                            <p class="text-xs text-slate-500">
                                Data permohonan sesuai filter yang dipilih.
                            </p>

                        </div>


                        <span class="text-sm font-semibold text-slate-500">
                            {{ $data->count() }} periode
                        </span>

                    </div>

                </div>



                {{-- =================================================
                    DATA ADA
                ================================================== --}}
                @if($data->count())

                    <div class="overflow-x-auto">

                        <table class="w-full text-sm">

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
                                        <td class="px-4 py-3 font-semibold text-slate-800 sm:px-5">

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

                                            <span class="inline-flex min-w-[80px] justify-center rounded-lg bg-blue-50 px-3 py-1.5 font-bold text-blue-700">
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

                    <div class="px-5 py-12 text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-2xl text-slate-400">
                            ▤
                        </div>

                        <h3 class="mt-4 font-bold text-slate-800">
                            Tidak ada data
                        </h3>

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
            <div class="mt-4 flex flex-wrap justify-end gap-2 print:hidden">

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