<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun | Sistem Rekap</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root{--primary:#2563eb;--bg:#f5f7fb;--text:#172033;--muted:#718096;--line:#e7ebf2;--white:#fff;--danger:#dc2626}
        *{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--text);font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif}a{text-decoration:none;color:inherit}.page{max-width:1050px;margin:0 auto;padding:30px 22px 50px}.top{display:flex;justify-content:space-between;align-items:center;gap:15px;margin-bottom:24px}.back{font-size:13px;color:#64748b;font-weight:700}.back:hover{color:var(--primary)}h1{margin:4px 0 0;font-size:26px}.sub{margin:6px 0 0;color:var(--muted);font-size:13px}.grid{display:grid;grid-template-columns:300px 1fr;gap:18px}.card{background:#fff;border:1px solid var(--line);border-radius:16px;box-shadow:0 4px 16px rgba(20,32,56,.035)}.identity{padding:24px}.avatar{width:72px;height:72px;border-radius:18px;background:#eff5ff;color:var(--primary);display:grid;place-items:center;font-size:28px;font-weight:800;margin-bottom:16px}.identity h2{font-size:18px;margin:0}.role{display:inline-block;margin-top:7px;padding:5px 9px;border-radius:7px;background:#eff5ff;color:#3566c6;font-size:10px;font-weight:800;text-transform:uppercase}.meta{margin-top:20px;display:grid;gap:12px}.meta div{font-size:12px;color:#64748b}.meta strong{display:block;color:#263247;margin-top:3px}.forms{display:grid;gap:18px}.head{padding:19px 22px;border-bottom:1px solid var(--line)}.head h3{margin:0;font-size:15px}.head p{margin:5px 0 0;font-size:11px;color:#8a95a6}.body{padding:22px}.fields{display:grid;grid-template-columns:1fr 1fr;gap:15px}.field{display:grid;gap:7px}.field.full{grid-column:1/-1}.field label{font-size:11px;font-weight:800;color:#4b5565}.field input{width:100%;height:42px;border:1px solid #dfe4ec;border-radius:9px;padding:0 12px;font-size:13px;outline:none;background:#fff}.field input:focus{border-color:#93b4f5;box-shadow:0 0 0 3px #eff5ff}.field input[disabled]{background:#f8fafc;color:#8b95a5}.error{font-size:10px;color:var(--danger)}.actions{display:flex;justify-content:flex-end;margin-top:18px}.btn{border:0;border-radius:9px;background:var(--primary);color:#fff;padding:10px 16px;font-size:12px;font-weight:800;cursor:pointer}.btn:hover{background:#1d4ed8}.alert{padding:11px 13px;border-radius:9px;background:#ecfdf3;color:#15803d;border:1px solid #bbf7d0;font-size:12px;margin-bottom:16px}.note{font-size:11px;color:#8a95a6;margin-top:9px}.security{background:#f8faff;border:1px solid #dbe7ff;border-radius:10px;padding:12px;margin-bottom:17px;font-size:11px;color:#5d6b82}@media(max-width:800px){.grid{grid-template-columns:1fr}.fields{grid-template-columns:1fr}.field.full{grid-column:auto}.top{align-items:flex-start;flex-direction:column}}
    </style>
</head>
<body>
@include('layouts.sidebar')
<main class="sipper-content">
@include('layouts.header', ['pageTitle' => 'Pengaturan Akun'])
<div class="page">
    <div class="top">
        <div><a class="back" href="{{ route('dashboard') }}">← Kembali ke Dashboard</a><h1>Pengaturan Akun</h1><p class="sub">Kelola profil dan keamanan akun {{ $user->role === 'admin' ? 'admin' : 'petugas' }}.</p></div>
    </div>

    @if(session('status'))<div class="alert">✓ {{ session('status') }}</div>@endif

    <div class="grid">
        <aside class="card identity">
            <div class="avatar">{{ strtoupper(substr($user->name,0,1)) }}</div>
            <h2>{{ $user->name }}</h2>
            <span class="role">{{ $user->role }}</span>
            <div class="meta">
                <div>Username<strong>{{ $user->username }}</strong></div>
                <div>Email<strong>{{ $user->email }}</strong></div>
            </div>
        </aside>

        <div class="forms">
            <section class="card">
                <div class="head"><h3>Profil Akun</h3><p>Ubah nama, username, dan email akun.</p></div>
                <div class="body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        <div class="fields">
                            <div class="field"><label>Nama</label><input type="text" name="name" value="{{ old('name',$user->name) }}" required>@error('name')<span class="error">{{ $message }}</span>@enderror</div>
                            <div class="field"><label>Username</label><input type="text" name="username" value="{{ old('username',$user->username) }}" required>@error('username')<span class="error">{{ $message }}</span>@enderror</div>
                            <div class="field full"><label>Email</label><input type="email" name="email" value="{{ old('email',$user->email) }}" required>@error('email')<span class="error">{{ $message }}</span>@enderror</div>
                            <div class="field full"><label>Role</label><input type="text" value="{{ ucfirst($user->role) }}" disabled></div>
                        </div>
                        <div class="actions"><button class="btn" type="submit">Simpan Profil</button></div>
                    </form>
                </div>
            </section>

            <section class="card">
                <div class="head"><h3>Keamanan & Password</h3><p>Ganti password login akun secara aman.</p></div>
                <div class="body">
                    <div class="security">Password lama wajib diisi. Password baru minimal <strong>8 karakter</strong> dan harus dikonfirmasi ulang.</div>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <div class="fields">
                            <div class="field full"><label>Password Lama</label><input type="password" name="current_password" autocomplete="current-password" required>@error('current_password')<span class="error">{{ $message }}</span>@enderror</div>
                            <div class="field"><label>Password Baru</label><input type="password" name="new_password" autocomplete="new-password" minlength="8" required>@error('new_password')<span class="error">{{ $message }}</span>@enderror</div>
                            <div class="field"><label>Konfirmasi Password Baru</label><input type="password" name="new_password_confirmation" autocomplete="new-password" minlength="8" required></div>
                        </div>
                        <div class="actions"><button class="btn" type="submit">Ubah Password</button></div>
                    </form>
                </div</main>
>
            </section>
        </div>
    </div>
</div>
</body>
</html>
