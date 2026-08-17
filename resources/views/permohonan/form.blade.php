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

<body class="min-h-screen overflow-x-hidden bg-slate-100 text-slate-800">

    {{-- SIDEBAR --}}
    @include('layouts.sidebar')


    {{-- KONTEN UTAMA --}}
    <main class="sipper-content">

        <div class="min-h-screen px-3 py-3 sm:px-4 sm:py-4 lg:px-5 lg:py-5">

            <div class="w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                @php
                    /*
                    |--------------------------------------------------------------------------
                    | DATA AWAL
                    |--------------------------------------------------------------------------
                    */

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
                    HEADER
                ====================================================== --}}
                <div class="border-b border-slate-200 px-5 py-4 sm:px-6">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-600">
                                Berita Acara
                            </p>

                            <h1 class="mt-1 text-xl font-bold text-slate-900 sm:text-2xl">
                                {{ isset($permohonan) ? 'Edit Data Rekap' : 'Input Rekap Baru' }}
                            </h1>

                            <p class="mt-1 text-xs text-slate-500 sm:text-sm">
                                Isi data sesuai jenis pelayanan.
                            </p>

                        </div>


                        <a
                            href="{{ route('permohonan.index') }}"
                            class="rounded-xl border border-slate-300 px-4 py-2 text-center text-sm font-bold transition hover:bg-slate-50"
                        >
                            ← Kembali
                        </a>

                    </div>

                </div>


                {{-- =====================================================
                    ERROR
                ====================================================== --}}
                @if($errors->any())

                    <div class="mx-5 mt-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 sm:mx-6">

                        <p class="font-bold">
                            Data belum dapat disimpan.
                        </p>

                        <ul class="mt-2 list-disc pl-5">

                            @foreach($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- =====================================================
                    FORM
                ====================================================== --}}
                <form
                    method="POST"
                    action="{{ isset($permohonan)
                        ? route('permohonan.update', $permohonan)
                        : route('permohonan.store') }}"
                    class="px-5 py-5 sm:px-6"
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


                    {{-- =================================================
                        JENIS REKAP
                    ================================================== --}}
                    <section>

                        <label class="mb-2 block text-sm font-bold text-slate-900">

                            Jenis Rekap

                            <span class="text-red-500">*</span>

                        </label>


                        <div class="grid grid-cols-2 gap-2 sm:grid-cols-3 lg:grid-cols-6">

                            @foreach($kelompokPelayanans as $group)

                                <button
                                    type="button"
                                    class="service-tab rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm font-bold text-slate-700 transition hover:border-blue-400 hover:bg-blue-50"
                                    data-group="{{ $group->id }}"
                                >

                                    {{ $group->kode === 'SURAT_PINDAH'
                                        ? 'SURAT PINDAH'
                                        : $group->kode }}

                                </button>

                            @endforeach

                        </div>

                    </section>


                    {{-- =================================================
                        DATA PEMOHON
                    ================================================== --}}
                    <section class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:p-5">

                        {{-- HEADER --}}
                        <div class="border-b border-slate-200 pb-3">

                            <h2 class="font-bold text-slate-900">
                                Data Pemohon
                            </h2>

                            <p
                                id="category_hint"
                                class="mt-1 text-xs text-slate-500 sm:text-sm"
                            >
                                Pilih jenis rekap di bagian atas.
                            </p>

                        </div>


                        {{-- =================================================
                            FORM KHUSUS JENIS PELAYANAN
                            
                            POSISI:
                            Jenis KK / Jenis Akta
                            BERADA SEBELUM NAMA
                        ================================================== --}}

                        <div class="mt-4">

                            @foreach($kelompokPelayanans as $group)

                                <div
                                    class="category-panel hidden"
                                    data-panel="{{ $group->id }}"
                                    data-code="{{ $group->kode }}"
                                >

                                    {{-- =================================================
                                        HIDDEN JENIS PELAYANAN
                                    ================================================== --}}
                                    <input
                                        type="hidden"
                                        name="jenis_pelayanan_id"
                                        class="jenis-hidden"
                                        value="{{ $group->jenisPelayanans->first()?->id }}"
                                        disabled
                                    >


                                    {{-- =================================================
                                        DROPDOWN JENIS PELAYANAN
                                        
                                        AKTA
                                        KTP
                                        KK
                                    ================================================== --}}

                                    @if(in_array($group->kode, ['AKTA', 'KTP', 'KK']))

                                        <div class="mb-4">

                                            <label class="mb-1 block text-sm font-semibold text-slate-800">

                                                @if($group->kode === 'AKTA')
                                                    Jenis Akta
                                                @elseif($group->kode === 'KTP')
                                                    Jenis KTP
                                                @else
                                                    Jenis KK
                                                @endif

                                                <span class="text-red-500">*</span>

                                            </label>


                                            <select
                                                name="jenis_pelayanan_select"
                                                class="jenis-dropdown w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                                                data-group="{{ $group->id }}"
                                                disabled
                                                required
                                            >

                                                <option value="">

                                                    Pilih
                                                    @if($group->kode === 'AKTA')
                                                        Jenis Akta
                                                    @elseif($group->kode === 'KTP')
                                                        Jenis KTP
                                                    @else
                                                        Jenis KK
                                                    @endif

                                                </option>


                                                @foreach($group->jenisPelayanans as $jenis)

                                                    <option
                                                        value="{{ $jenis->id }}"
                                                        {{ (int)$selectedJenisId === (int)$jenis->id ? 'selected' : '' }}
                                                    >

                                                        {{ $jenis->nama_pelayanan }}

                                                    </option>

                                                @endforeach

                                            </select>

                                        </div>

                                    @endif


                                    {{-- =================================================
                                        DATA UTAMA
                                    ================================================== --}}

                                    <div class="grid gap-4 md:grid-cols-2">


                                        {{-- NAMA --}}
                                        <div>

                                            <label class="mb-1 block text-sm font-semibold">

                                                Nama

                                                <span class="text-red-500">*</span>

                                            </label>

                                            <input
                                                name="nama_pemohon"
                                                value="{{ old(
                                                    'nama_pemohon',
                                                    $permohonan->nama_pemohon ?? ''
                                                ) }}"
                                                required
                                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                                                placeholder="Nama"
                                                disabled
                                            >

                                        </div>


                                        {{-- TANGGAL --}}
                                        <div>

                                            <label class="mb-1 block text-sm font-semibold">

                                                Tanggal

                                                <span class="text-red-500">*</span>

                                            </label>

                                            <input
                                                type="date"
                                                name="tanggal_permohonan"
                                                value="{{ old(
                                                    'tanggal_permohonan',
                                                    isset($permohonan)
                                                        ? $permohonan->tanggal_permohonan?->format('Y-m-d')
                                                        : now()->format('Y-m-d')
                                                ) }}"
                                                required
                                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                                                disabled
                                            >

                                        </div>


                                        {{-- KECAMATAN --}}
                                        <div>

                                            <label class="mb-1 block text-sm font-semibold">

                                                Kecamatan

                                                <span class="text-red-500">*</span>

                                            </label>

                                            <select
                                                name="kecamatan_id"
                                                id="kecamatan_id"
                                                required
                                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                                                disabled
                                            >

                                                <option value="">
                                                    Pilih Kecamatan
                                                </option>


                                                @foreach($kecamatans as $kecamatan)

                                                    <option
                                                        value="{{ $kecamatan->id }}"
                                                        {{ (string)old(
                                                            'kecamatan_id',
                                                            $permohonan->kecamatan_id ?? ''
                                                        ) === (string)$kecamatan->id
                                                            ? 'selected'
                                                            : '' }}
                                                    >

                                                        {{ $kecamatan->nama_kecamatan }}

                                                    </option>

                                                @endforeach

                                            </select>

                                        </div>


                                        {{-- DESA --}}
                                        <div>

                                            <label class="mb-1 block text-sm font-semibold">

                                                Desa/Kelurahan

                                                <span class="text-red-500">*</span>

                                            </label>

                                            <select
                                                name="desa_id"
                                                id="desa_id"
                                                required
                                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                                                disabled
                                            >

                                                <option value="">
                                                    Pilih Desa/Kelurahan
                                                </option>


                                                @foreach($desas as $desa)

                                                    <option
                                                        value="{{ $desa->id }}"
                                                        data-kecamatan="{{ $desa->kecamatan_id }}"
                                                        {{ (string)old(
                                                            'desa_id',
                                                            $permohonan->desa_id ?? ''
                                                        ) === (string)$desa->id
                                                            ? 'selected'
                                                            : '' }}
                                                    >

                                                        {{ $desa->nama_desa }}

                                                    </option>

                                                @endforeach

                                            </select>

                                        </div>

                                    </div>


                                    {{-- =================================================
                                        NO KENDALI AKTA
                                    ================================================== --}}

                                    @if($group->kode === 'AKTA')

                                        <div class="mt-4">

                                            <label class="mb-1 block text-sm font-semibold">

                                                No. Kendali

                                                <span class="text-red-500">*</span>

                                            </label>

                                            <input
                                                name="detail_data[nomor_kendali]"
                                                value="{{ $detail['nomor_kendali'] ?? '' }}"
                                                class="detail-kendali w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                                                disabled
                                                placeholder="Masukkan nomor kendali"
                                            >

                                        </div>

                                    @endif


                                    {{-- =================================================
                                        KETERANGAN
                                    ================================================== --}}

                                    @if(in_array($group->kode, [
                                        'KK',
                                        'KTP',
                                        'SURAT_PINDAH',
                                        'PEREKAMAN'
                                    ]))

                                        <div class="mt-4">

                                            <label class="mb-1 block text-sm font-semibold">

                                                Keterangan / Pemohon

                                            </label>

                                            <input
                                                name="keterangan"
                                                value="{{ old(
                                                    'keterangan',
                                                    $permohonan->keterangan ?? ''
                                                ) }}"
                                                class="category-keterangan w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                                                disabled
                                                placeholder="Contoh: YBS, Suami, Istri, Anak, Kuasa"
                                            >


                                            @if($group->kode === 'PEREKAMAN')

                                                <p class="mt-1 text-xs text-slate-500">

                                                    Untuk perekaman dapat diisi
                                                    "Pemula" atau keterangan lain sesuai kebutuhan.

                                                </p>

                                            @endif

                                        </div>

                                    @endif

                                </div>

                            @endforeach


                            {{-- =================================================
                                EMPTY STATE
                            ================================================== --}}

                            <div
                                id="empty_category"
                                class="rounded-xl border border-dashed border-slate-300 bg-white p-5 text-center text-sm text-slate-500"
                            >

                                Pilih jenis rekap di bagian atas.

                            </div>

                        </div>

                    </section>


                    {{-- =================================================
                        BUTTON
                    ================================================== --}}

                    <div class="mt-4 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('permohonan.index') }}"
                            class="rounded-xl border border-slate-300 px-5 py-2.5 text-center text-sm font-bold transition hover:bg-slate-50"
                        >
                            Batal
                        </a>


                        <button
                            type="submit"
                            class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-blue-700"
                        >

                            {{ isset($permohonan)
                                ? 'Simpan Perubahan'
                                : 'Simpan Rekap' }}

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </main>


    {{-- =========================================================
        JAVASCRIPT
    ========================================================== --}}
    <script>

        document.addEventListener('DOMContentLoaded', () => {

            const tabs = [
                ...document.querySelectorAll('.service-tab')
            ];

            const panels = [
                ...document.querySelectorAll('.category-panel')
            ];

            const kecamatan =
                document.getElementById('kecamatan_id');

            const desa =
                document.getElementById('desa_id');

            const empty =
                document.getElementById('empty_category');

            const hint =
                document.getElementById('category_hint');


            /*
            |--------------------------------------------------------------------------
            | FILTER DESA
            |--------------------------------------------------------------------------
            */

            function filterDesa() {

                if (!kecamatan || !desa) {
                    return;
                }

                const kecId = kecamatan.value;

                [
                    ...desa.options
                ].forEach(option => {

                    if (!option.value) {
                        return;
                    }

                    option.hidden =
                        option.dataset.kecamatan !== kecId;

                });


                if (
                    desa.value &&
                    desa.options[desa.selectedIndex]?.dataset.kecamatan !== kecId
                ) {

                    desa.value = '';

                }

            }


            /*
            |--------------------------------------------------------------------------
            | AKTIFKAN PANEL
            |--------------------------------------------------------------------------
            */

            function activate(groupId) {

                /*
                |--------------------------------------------------------------------------
                | TAB
                |--------------------------------------------------------------------------
                */

                tabs.forEach(tab => {

                    const active =
                        tab.dataset.group === String(groupId);


                    tab.classList.toggle(
                        'bg-blue-600',
                        active
                    );

                    tab.classList.toggle(
                        'text-white',
                        active
                    );

                    tab.classList.toggle(
                        'border-blue-600',
                        active
                    );

                    tab.classList.toggle(
                        'bg-white',
                        !active
                    );

                    tab.classList.toggle(
                        'text-slate-700',
                        !active
                    );

                });


                /*
                |--------------------------------------------------------------------------
                | PANEL
                |--------------------------------------------------------------------------
                */

                panels.forEach(panel => {

                    const active =
                        panel.dataset.panel === String(groupId);


                    panel.classList.toggle(
                        'hidden',
                        !active
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | SEMUA INPUT DI PANEL
                    |--------------------------------------------------------------------------
                    */

                    panel
                        .querySelectorAll(
                            'input, select'
                        )
                        .forEach(el => {

                            el.disabled = !active;

                        });


                    /*
                    |--------------------------------------------------------------------------
                    | INPUT JENIS PELAYANAN
                    |--------------------------------------------------------------------------
                    */

                    const hidden =
                        panel.querySelector('.jenis-hidden');

                    const dropdown =
                        panel.querySelector('.jenis-dropdown');


                    if (active) {

                        /*
                        |--------------------------------------------------------------------------
                        | DROPDOWN JENIS
                        |--------------------------------------------------------------------------
                        */

                        if (dropdown) {

                            dropdown.disabled = false;

                            /*
                            | Jika ada pilihan sebelumnya,
                            | sinkronkan ke hidden input.
                            */

                            if (hidden) {

                                hidden.disabled = false;

                                hidden.value =
                                    dropdown.value;

                            }

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | PANEL YANG TIDAK MEMILIKI DROPDOWN
                        |--------------------------------------------------------------------------
                        */

                        else if (hidden) {

                            hidden.disabled = false;

                        }

                    }

                });


                /*
                |--------------------------------------------------------------------------
                | EMPTY STATE
                |--------------------------------------------------------------------------
                */

                empty.classList.toggle(
                    'hidden',
                    !!groupId
                );


                /*
                |--------------------------------------------------------------------------
                | HINT
                |--------------------------------------------------------------------------
                */

                const tab =
                    tabs.find(
                        t =>
                            t.dataset.group === String(groupId)
                    );


                hint.textContent =
                    tab
                        ? `Form ${tab.textContent.trim()} sedang aktif.`
                        : 'Pilih jenis rekap.';

            }


            /*
            |--------------------------------------------------------------------------
            | DROPDOWN JENIS PELAYANAN
            |--------------------------------------------------------------------------
            */

            document
                .querySelectorAll('.jenis-dropdown')
                .forEach(dropdown => {

                    dropdown.addEventListener(
                        'change',
                        () => {

                            const panel =
                                dropdown.closest(
                                    '.category-panel'
                                );


                            const hidden =
                                panel.querySelector(
                                    '.jenis-hidden'
                                );


                            if (hidden) {

                                hidden.value =
                                    dropdown.value;

                            }

                        }
                    );

                });


            /*
            |--------------------------------------------------------------------------
            | TAB KATEGORI
            |--------------------------------------------------------------------------
            */

            tabs.forEach(tab => {

                tab.addEventListener(
                    'click',
                    () => {

                        activate(
                            tab.dataset.group
                        );

                    }
                );

            });


            /*
            |--------------------------------------------------------------------------
            | KECAMATAN
            |--------------------------------------------------------------------------
            */

            if (kecamatan) {

                kecamatan.addEventListener(
                    'change',
                    filterDesa
                );

            }


            /*
            |--------------------------------------------------------------------------
            | INITIAL DESA
            |--------------------------------------------------------------------------
            */

            filterDesa();


            /*
            |--------------------------------------------------------------------------
            | KATEGORI AWAL
            |--------------------------------------------------------------------------
            */

            const initial =
                document.getElementById(
                    'selected_group'
                ).value;


            if (initial) {

                activate(initial);

            }

            /*
            |--------------------------------------------------------------------------
            | JIKA INPUT BARU
            |--------------------------------------------------------------------------
            */

            else if (tabs.length) {

                activate(
                    tabs[0].dataset.group
                );

            }

        });

    </script>

</body>

</html>