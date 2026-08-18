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

        <div class="min-h-screen px-4 py-4 sm:px-6 lg:px-6">



            {{-- =====================================================
                FILTER REKAP
                SATU BARIS
            ====================================================== --}}
            <div class="mb-4 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">

                <form
                    method="GET"
                    action="{{ route('permohonan.recap') }}"
                    class="flex flex-col gap-3 lg:flex-row lg:items-end"
                >

                    {{-- PERIODE --}}
                    <div class="w-full lg:w-36">

                        <label class="mb-1 block text-xs font-bold text-slate-600">
                            Periode
                        </label>

                        <select
                            name="period"
                            class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
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
                    <div class="w-full lg:w-28">

                        <label class="mb-1 block text-xs font-bold text-slate-600">
                            Tahun
                        </label>

                        <select
                            name="year"
                            class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
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
                    <div class="w-full lg:w-40">

                        <label class="mb-1 block text-xs font-bold text-slate-600">
                            Bulan
                        </label>

                        <select
                            name="month"
                            class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
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
                    <div class="w-full lg:flex-1">

                        <label class="mb-1 block text-xs font-bold text-slate-600">
                            Kategori Permohonan
                        </label>

                        <select
                            name="kelompok_pelayanan_id"
                            class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
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
                    <div class="flex gap-2">

                        <button
                            type="submit"
                            class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-blue-700"
                        >
                            Filter
                        </button>

                        <a
                            href="{{ route('permohonan.recap') }}"
                            class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-bold text-slate-700 transition hover:bg-slate-50"
                        >
                            Reset
                        </a>

                    </div>

                </form>

            </div>



            {{-- =====================================================
                RINGKASAN FILTER AKTIF
            ====================================================== --}}
            <div class="mb-4 rounded-2xl border border-blue-100 bg-blue-50 px-4 py-3">

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
                    <div class="rounded-xl bg-white px-4 py-2 text-center shadow-sm">

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
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">


                {{-- HEADER TABEL --}}
                <div class="border-b border-slate-200 px-5 py-4">

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

                                    <th class="w-16 px-5 py-3 text-left font-bold text-slate-600">
                                        No
                                    </th>

                                    <th class="px-5 py-3 text-left font-bold text-slate-600">
                                        Periode
                                    </th>

                                    <th class="px-5 py-3 text-right font-bold text-slate-600">
                                        Jumlah Permohonan
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-slate-100">

                                @foreach($data as $index => $item)

                                    <tr class="transition hover:bg-slate-50">

                                        {{-- NO --}}
                                        <td class="px-5 py-3 text-slate-500">
                                            {{ $index + 1 }}
                                        </td>


                                        {{-- PERIODE --}}
                                        <td class="px-5 py-3 font-semibold text-slate-800">

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
                                        <td class="px-5 py-3 text-right">

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
                                        class="px-5 py-4 text-right font-bold text-slate-700"
                                    >
                                        Total
                                    </td>

                                    <td class="px-5 py-4 text-right">

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
            <div class="mt-3 flex justify-end">

                <a
                    href="{{ route('permohonan.export', [
                        'format' => 'csv',
                        'year' => $year,
                        'month' => $month,
                        'kelompok_pelayanan_id' => $kelompokPelayananId
                    ]) }}"
                    class="rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700"
                >
                    ↓ Export CSV
                </a>

            </div>


        </div>

    </main>

</body>

</html>