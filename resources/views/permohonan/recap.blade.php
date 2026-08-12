<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rekapitulasi - Sistem Rekap</title>

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
    <main class="sipper-content min-h-screen">

        <div class="w-full px-4 py-4 sm:px-5 lg:px-6">

            {{-- =================================================
                HEADER
            ================================================== --}}
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-blue-600">
                        Sistem Rekap
                    </p>

                    <h1 class="mt-1 text-xl font-bold text-slate-900 sm:text-2xl">
                        Rekapitulasi Permohonan
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Ringkasan jumlah permohonan pelayanan berdasarkan periode.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">

                    <a
                        href="{{ route('permohonan.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-50"
                    >
                        ← Data Rekap
                    </a>

                    <a
                        href="{{ route('permohonan.export', ['format' => 'csv']) }}"
                        class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-blue-700"
                    >
                        ⇩ Export CSV
                    </a>

                </div>

            </div>


            {{-- =================================================
                FILTER / INFORMASI PERIODE
            ================================================== --}}
            <div class="mb-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Periode Rekapitulasi
                        </p>

                        <p class="mt-1 text-base font-bold text-slate-900">
                            {{ $period ?? 'Semua Periode' }}
                            <span class="font-normal text-slate-400">|</span>
                            Tahun {{ $year ?? date('Y') }}
                        </p>
                    </div>

                    <div class="rounded-xl bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">
                        {{ $data->sum('total') }} Total Permohonan
                    </div>

                </div>

            </div>


            {{-- =================================================
                ERROR / SUCCESS
            ================================================== --}}
            @if(session('status'))

                <div class="mb-4 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                    {{ session('status') }}
                </div>

            @endif


            @if(session('error'))

                <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                    {{ session('error') }}
                </div>

            @endif


            {{-- =================================================
                KARTU STATISTIK
            ================================================== --}}
            <div class="mb-4 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">

                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                    <p class="text-sm font-medium text-slate-500">
                        Total Permohonan
                    </p>

                    <p class="mt-1 text-2xl font-bold text-slate-900">
                        {{ $data->sum('total') }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Seluruh data yang tercatat
                    </p>

                </div>


                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                    <p class="text-sm font-medium text-slate-500">
                        Jumlah Periode
                    </p>

                    <p class="mt-1 text-2xl font-bold text-slate-900">
                        {{ $data->count() }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Periode yang memiliki data
                    </p>

                </div>


                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                    <p class="text-sm font-medium text-slate-500">
                        Rata-rata Permohonan
                    </p>

                    <p class="mt-1 text-2xl font-bold text-slate-900">
                        {{ $data->count() > 0 ? number_format($data->avg('total'), 0, ',', '.') : 0 }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Rata-rata setiap periode
                    </p>

                </div>

            </div>


            {{-- =================================================
                TABEL REKAP
            ================================================== --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- HEADER TABEL --}}
                <div class="flex flex-col gap-2 border-b border-slate-200 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h2 class="text-base font-bold text-slate-900">
                            Data Rekapitulasi
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500">
                            Jumlah permohonan berdasarkan tanggal/periode.
                        </p>

                    </div>

                    <span class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                        {{ $data->count() }} Data
                    </span>

                </div>


                {{-- TABLE --}}
                <div class="overflow-x-auto">

                    <table class="w-full text-left text-sm">

                        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">

                            <tr>

                                <th class="whitespace-nowrap px-4 py-3 font-bold">
                                    No
                                </th>

                                <th class="whitespace-nowrap px-4 py-3 font-bold">
                                    Periode
                                </th>

                                <th class="whitespace-nowrap px-4 py-3 text-right font-bold">
                                    Jumlah Permohonan
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @forelse($data as $item)

                                <tr class="transition hover:bg-slate-50">

                                    <td class="whitespace-nowrap px-4 py-3 text-slate-500">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="whitespace-nowrap px-4 py-3">

                                        <div class="font-semibold text-slate-800">
                                            {{ $item->period }}
                                        </div>

                                    </td>

                                    <td class="whitespace-nowrap px-4 py-3 text-right">

                                        <span class="inline-flex min-w-[90px] justify-center rounded-lg bg-blue-50 px-3 py-1.5 font-bold text-blue-700">

                                            {{ number_format($item->total, 0, ',', '.') }}

                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="3"
                                        class="px-4 py-12 text-center"
                                    >

                                        <div class="mx-auto max-w-sm">

                                            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-xl text-slate-400">
                                                ▤
                                            </div>

                                            <p class="font-semibold text-slate-700">
                                                Belum ada data rekapitulasi
                                            </p>

                                            <p class="mt-1 text-sm text-slate-400">
                                                Data permohonan akan muncul setelah terdapat permohonan yang tercatat.
                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>


                        {{-- TOTAL --}}
                        @if($data->count() > 0)

                            <tfoot class="border-t border-slate-200 bg-slate-50">

                                <tr>

                                    <td
                                        colspan="2"
                                        class="px-4 py-3 text-right font-bold text-slate-700"
                                    >
                                        Total
                                    </td>

                                    <td class="px-4 py-3 text-right">

                                        <span class="inline-flex min-w-[90px] justify-center rounded-lg bg-blue-600 px-3 py-1.5 font-bold text-white">

                                            {{ number_format($data->sum('total'), 0, ',', '.') }}

                                        </span>

                                    </td>

                                </tr>

                            </tfoot>

                        @endif

                    </table>

                </div>

            </div>


            {{-- =================================================
                FOOTER INFORMASI
            ================================================== --}}
            <div class="mt-3 flex flex-col gap-1 text-xs text-slate-400 sm:flex-row sm:items-center sm:justify-between">

                <span>
                    Sistem Rekap Dispendukcapil Kabupaten Magetan
                </span>

                <span>
                    Data diperbarui secara otomatis dari data permohonan.
                </span>

            </div>

        </div>

    </main>

</body>

</html>