<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login BERITA ACARA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo-go-digital.svg') }}" alt="Logo GO Digital Disdukcapil Magetan" class="mx-auto w-16 h-auto mb-4 object-contain" style="width:64px;">
            <h2 class="text-2xl font-bold text-slate-800">Login Berita Acara</h2>
            <p class="text-sm text-slate-500 mt-2">Masuk untuk mengakses Berita Acara permohonan</p>
        </div>

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Username atau Email</label>
                <input type="text" name="login" value="{{ old('login') }}" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('login')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                class="w-full rounded-lg bg-blue-600 px-4 py-2 text-white font-semibold hover:bg-blue-700 transition">
                Login
            </button>

            <p class="text-center text-xs text-slate-400">Jika Anda melihat halaman kadaluarsa, refresh halaman lalu coba lagi.</p>
        </form>
    </div>
</body>
</html>
