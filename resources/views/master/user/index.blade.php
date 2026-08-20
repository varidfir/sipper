<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Pengguna - Berita Acara</title>

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
        @include('layouts.header', ['pageTitle' => 'Kelola Pengguna'])

        <div class="page-shell">

            <div class="form-page-container">


                {{-- =================================================
                    HEADER
                ================================================== --}}
                <div class="form-header">
                    <div class="form-title-group">
                        <h1>Kelola Pengguna</h1>
                        <p>Kelola akun pengguna yang dapat mengakses sistem SIPPER.</p>
                    </div>


                    {{-- TOMBOL TAMBAH --}}
                    <a
                        href="{{ route('user.create') }}"
                        class="primary-btn"
                    >

                        <span class="text-lg leading-none">
                            +
                        </span>

                        Tambah Pengguna

                    </a>

                </div>



                {{-- =================================================
                    NOTIFIKASI
                ================================================== --}}
                @if(session('status'))

                    <div
                        class="mb-4 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
                    >

                        <span class="font-bold">
                            ✓
                        </span>

                        <span>
                            {{ session('status') }}
                        </span>

                    </div>

                @endif



                {{-- =================================================
                    STATISTIK
                ================================================== --}}
                @php

                    $totalUsers = $users->count();

                    $totalAdmin = $users->where('role', 'admin')->count();

                    $totalPetugas = $users->where('role', 'petugas')->count();

                @endphp


                <div class="mb-4 grid grid-cols-1 gap-3 sm:grid-cols-3">


                    {{-- TOTAL --}}
                    <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Total Pengguna
                                </p>

                                <p class="mt-1 text-2xl font-bold text-slate-900">
                                    {{ $totalUsers }}
                                </p>

                            </div>

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-lg text-blue-600">
                                👥
                            </div>

                        </div>

                    </div>



                    {{-- ADMIN --}}
                    <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Administrator
                                </p>

                                <p class="mt-1 text-2xl font-bold text-slate-900">
                                    {{ $totalAdmin }}
                                </p>

                            </div>

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 text-lg text-purple-600">
                                🛡
                            </div>

                        </div>

                    </div>



                    {{-- PETUGAS --}}
                    <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Petugas
                                </p>

                                <p class="mt-1 text-2xl font-bold text-slate-900">
                                    {{ $totalPetugas }}
                                </p>

                            </div>

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-lg text-emerald-600">
                                ✓
                            </div>

                        </div>

                    </div>

                </div>



                {{-- =================================================
                    TABEL PENGGUNA
                ================================================== --}}
                <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">


                    {{-- HEADER TABEL --}}
                    <div class="border-b border-slate-200 px-4 py-4 sm:px-5">

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                            <div>

                                <h2 class="font-bold text-slate-900">
                                    Daftar Pengguna
                                </h2>

                                <p class="mt-1 text-xs text-slate-500">
                                    Daftar akun pengguna SIPPER.
                                </p>

                            </div>


                            {{-- SEARCH --}}
                            <div class="relative w-full sm:w-64">

                                <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                    
                                </span>

                                <input
                                    type="text"
                                    id="searchUser"
                                    placeholder="Cari pengguna..."
                                    class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 pl-9 pr-3 text-sm outline-none transition focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100"
                                >

                            </div>

                        </div>

                    </div>



                    {{-- =================================================
                        TABLE
                    ================================================== --}}
                    <div class="overflow-x-auto">

                        <table class="sipper-data-table min-w-[700px] text-sm">

                            <thead>

                                <tr class="border-b border-slate-200 text-left">

                                    <th>
                                        No
                                    </th>

                                    <th>
                                        Pengguna
                                    </th>

                                    <th>
                                        Username
                                    </th>

                                    <th>
                                        Role
                                    </th>

                                    <th class="sipper-table-actions">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody
                                id="userTable"
                                class="divide-y divide-slate-100"
                            >

                                @forelse($users as $index => $user)

                                    <tr
                                        class="user-row transition hover:bg-slate-50"
                                        data-search="{{ strtolower(
                                            $user->name . ' ' .
                                            $user->username . ' ' .
                                            ($user->role ?? '')
                                        ) }}"
                                    >

                                        {{-- NO --}}
                                        <td class="px-5 py-4 text-slate-500">

                                            {{ $index + 1 }}

                                        </td>


                                        {{-- NAMA --}}
                                        <td class="sipper-table-actions px-5 py-4">

                                            <div class="flex items-center gap-3">


                                                {{-- AVATAR --}}
                                                <div
                                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-700"
                                                >

                                                    {{ strtoupper(
                                                        substr($user->name, 0, 1)
                                                    ) }}

                                                </div>


                                                <div>

                                                    <p class="font-bold text-slate-900">
                                                        {{ $user->name }}
                                                    </p>

                                                    <p class="text-xs text-slate-500">
                                                        Pengguna SIPPER
                                                    </p>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- USERNAME --}}
                                        <td class="px-5 py-4">

                                            <span class="text-slate-700">
                                                {{ $user->username }}
                                            </span>

                                        </td>


                                        {{-- ROLE --}}
                                        <td class="px-5 py-4">

                                            @if(strtolower($user->role ?? '') === 'admin')

                                                <span class="inline-flex items-center rounded-full bg-purple-100 px-3 py-1 text-xs font-bold text-purple-700">
                                                    Admin
                                                </span>

                                            @else

                                                <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">
                                                    Petugas
                                                </span>

                                            @endif

                                        </td>


                                        {{-- AKSI --}}
                                        <td class="px-5 py-4">

                                            <div class="flex items-center justify-end gap-2">


                                                {{-- EDIT --}}
                                                <a
                                                    href="{{ route('user.edit', $user) }}"
                                                    class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-bold text-slate-700 transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700"
                                                >

                                                    Edit

                                                </a>


                                                {{-- HAPUS --}}
                                                <form
                                                    method="POST"
                                                    action="{{ route('user.destroy', $user) }}"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}?')"
                                                >

                                                    @csrf

                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="rounded-lg border border-red-200 px-3 py-2 text-xs font-bold text-red-600 transition hover:bg-red-50"
                                                    >

                                                        Hapus

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>


                                @empty

                                    <tr>

                                        <td
                                            colspan="5"
                                            class="px-5 py-12 text-center"
                                        >

                                            <div class="mx-auto max-w-sm">

                                                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-xl">
                                                    👥
                                                </div>

                                                <p class="font-bold text-slate-700">
                                                    Belum ada pengguna
                                                </p>

                                                <p class="mt-1 text-sm text-slate-500">
                                                    Silakan tambahkan pengguna baru.
                                                </p>

                                            </div>

                                        </td>

                                    </tr>

                                @endforelse


                                {{-- HASIL SEARCH KOSONG --}}

                                <tr id="noSearchResult" class="hidden">

                                    <td
                                        colspan="5"
                                        class="px-5 py-10 text-center"
                                    >

                                        <p class="font-semibold text-slate-700">
                                            Pengguna tidak ditemukan.
                                        </p>

                                        <p class="mt-1 text-xs text-slate-500">
                                            Coba gunakan nama atau username lain.
                                        </p>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>


                    {{-- =================================================
                        FOOTER
                    ================================================== --}}
                    @if($users->count() > 0)

                        <div class="border-t border-slate-200 bg-slate-50 px-5 py-3">

                            <p class="text-xs text-slate-500">

                                Menampilkan
                                <span class="font-bold text-slate-700">
                                    {{ $users->count() }}
                                </span>
                                pengguna.

                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </main>



    {{-- =========================================================
        SEARCH JAVASCRIPT
    ========================================================== --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const searchInput =
                document.getElementById('searchUser');

            const rows =
                document.querySelectorAll('.user-row');

            const noResult =
                document.getElementById('noSearchResult');


            if (!searchInput) {
                return;
            }


            searchInput.addEventListener('input', function () {

                const keyword =
                    this.value.toLowerCase().trim();

                let visibleCount = 0;


                rows.forEach(function (row) {

                    const searchText =
                        row.dataset.search || '';


                    const matched =
                        searchText.includes(keyword);


                    row.classList.toggle(
                        'hidden',
                        !matched
                    );


                    if (matched) {
                        visibleCount++;
                    }

                });


                if (noResult) {

                    noResult.classList.toggle(
                        'hidden',
                        visibleCount !== 0
                    );

                }

            });

        });

    </script>

</body>

</html>