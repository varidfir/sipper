<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ isset($user) ? 'Edit Petugas' : 'Tambah Petugas' }} - Berita Acara
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100 text-slate-800 overflow-x-hidden">

    {{-- SIDEBAR GLOBAL --}}
    @include('layouts.sidebar')


    {{-- KONTEN UTAMA --}}
    <main class="sipper-content">
        @include('layouts.header', ['pageTitle' => isset($user) ? 'Edit Petugas' : 'Tambah Petugas'])

        <div class="min-h-screen p-4 sm:p-6 lg:p-8">

            <div class="mx-auto max-w-3xl">

                {{-- HEADER --}}
                <div class="mb-6">

                    <p class="text-sm font-bold uppercase tracking-[0.2em] text-blue-600">
                        Administrasi
                    </p>

                    <h1 class="mt-1 text-2xl font-bold text-slate-900">
                        {{ isset($user) ? 'Edit Petugas' : 'Tambah Petugas' }}
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ isset($user)
                            ? 'Perbarui data akun petugas.'
                            : 'Tambahkan akun petugas baru.'
                        }}
                    </p>

                </div>


                {{-- ERROR VALIDASI --}}
                @if($errors->any())

                    <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">

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


                {{-- FORM --}}
                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

                    <div class="border-b border-slate-200 px-5 py-5 sm:px-8">

                        <h2 class="text-lg font-bold text-slate-900">
                            Data Petugas
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Lengkapi data akun petugas.
                        </p>

                    </div>


                    <form
                        method="POST"
                        action="{{ isset($user) ? route('user.update', $user) : route('user.store') }}"
                        class="space-y-5 p-5 sm:p-8"
                    >

                        @csrf

                        @if(isset($user))
                            @method('PUT')
                        @endif


                        {{-- NAMA --}}
                        <div>

                            <label
                                for="name"
                                class="mb-1.5 block text-sm font-semibold text-slate-800"
                            >
                                Nama
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name ?? '') }}"
                                required
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="Masukkan nama petugas"
                            >

                            @error('name')

                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- USERNAME --}}
                        <div>

                            <label
                                for="username"
                                class="mb-1.5 block text-sm font-semibold text-slate-800"
                            >
                                Username
                            </label>

                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username', $user->username ?? '') }}"
                                required
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="Masukkan username"
                            >

                            @error('username')

                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- EMAIL --}}
                        <div>

                            <label
                                for="email"
                                class="mb-1.5 block text-sm font-semibold text-slate-800"
                            >
                                Email
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email ?? '') }}"
                                required
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="Masukkan email"
                            >

                            @error('email')

                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- PASSWORD --}}
                        <div>

                            <label
                                for="password"
                                class="mb-1.5 block text-sm font-semibold text-slate-800"
                            >
                                {{ isset($user) ? 'Password Baru (opsional)' : 'Password' }}
                            </label>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                {{ isset($user) ? '' : 'required' }}
                                minlength="8"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="{{ isset($user) ? 'Kosongkan jika tidak diubah' : 'Minimal 8 karakter' }}"
                            >

                            @if(isset($user))

                                <p class="mt-1.5 text-xs text-slate-500">
                                    Kosongkan jika tidak ingin mengubah password.
                                </p>

                            @else

                                <p class="mt-1.5 text-xs text-slate-500">
                                    Password minimal 8 karakter.
                                </p>

                            @endif


                            @error('password')

                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- KONFIRMASI PASSWORD --}}
                        @if(isset($user))

                            <div>

                                <label
                                    for="password_confirmation"
                                    class="mb-1.5 block text-sm font-semibold text-slate-800"
                                >
                                    Konfirmasi Password Baru
                                </label>

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    minlength="8"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                    placeholder="Ulangi password baru"
                                >

                            </div>

                        @endif


                        {{-- TOMBOL --}}
                        <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                            <a
                                href="{{ route('user.index') }}"
                                class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-bold text-slate-700 transition hover:bg-slate-50"
                            >
                                Batal
                            </a>


                            <button
                                type="submit"
                                class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-blue-700"
                            >
                                {{ isset($user) ? 'Simpan Perubahan' : 'Simpan Petugas' }}
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </main>

</body>
</html>