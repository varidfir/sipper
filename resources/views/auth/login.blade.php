<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login BERITA ACARA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-page min-h-screen flex items-center justify-center px-4">
    <div class="login-card w-full max-w-[16rem] rounded-lg shadow-lg p-2.5 sm:p-3">
        <div class="mb-2.5 text-center">
            <img src="{{ asset('images/logo-go-digital.svg') }}" alt="Logo GO Digital Disdukcapil Magetan" class="mx-auto mb-1 h-auto object-contain" style="width:36px;">
            <h2 class="text-[1.2rem] font-bold leading-tight text-slate-800">Login Berita Acara</h2>
            <p class="mt-0.5 text-[9px] text-slate-500">Masuk untuk mengakses Berita Acara permohonan</p>
        </div>

        <form method="POST" action="{{ route('login.post') }}" class="space-y-1.5">
            @csrf
            <div>
                <label class="mb-1 block text-xs font-medium text-slate-700">Username atau Email</label>
                <input type="text" name="login" value="{{ old('login') }}" required
                    class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('login')
                    <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-xs font-medium text-slate-700">Password</label>
                <input type="password" name="password" required
                    class="w-full rounded-md border border-slate-300 px-2.5 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                class="w-full rounded-md bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-blue-700">
                Login
            </button>

            <p class="text-center text-[10px] leading-relaxed text-slate-400">Jika Anda melihat halaman kadaluarsa, refresh halaman lalu coba lagi.</p>
        </form>
    </div>
</body>
</html>
