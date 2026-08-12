<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
</head>
<body>
@include('layouts.sidebar')
<main class="sipper-content">
    <h2>Ganti Password</h2>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <div>
            <label>Password Lama</label>
            <input type="password" name="current_password" required>
            @error('current_password')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label>Password Baru</label>
            <input type="password" name="new_password" required>
            @error('new_password')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation" required>
        </div>
        <</main>
button type="submit">Simpan Password</button>
    </form>
</body>
</html>
