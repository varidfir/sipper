@vite(['resources/css/app.css', 'resources/js/app.js'])
@include('layouts.sidebar')

<style>
    .petugas-form-page { min-height: 100vh; padding: 18px clamp(16px, 3vw, 32px) 32px; background: var(--sip-bg); }
    .petugas-form-panel { max-width: 920px; margin: 0 auto; overflow: hidden; border: 1px solid #dbe3ed; border-radius: 3px; background: #fff; box-shadow: 0 1px 3px rgba(15, 23, 42, .04); }
    .petugas-form-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 18px 20px; border-bottom: 1px solid #dbe3ed; }
    .petugas-kicker { margin: 0 0 4px; color: var(--sip-primary); font-size: 10px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
    .petugas-form-title { margin: 0; color: #0f172a; font-size: 22px; line-height: 1.2; }
    .petugas-form-subtitle { margin: 5px 0 0; color: #64748b; font-size: 12px; }
    .petugas-error { margin: 14px 20px 0; padding: 10px 12px; border: 1px solid #fecaca; border-radius: 3px; background: #fff1f2; color: #b91c1c; font-size: 12px; }
    .petugas-error p { margin: 0 0 4px; font-weight: 700; }
    .petugas-error ul { margin: 0; padding-left: 18px; }
    .petugas-form-content { padding: 18px 20px 20px; }
    .petugas-form-section { overflow: hidden; border: 1px solid #dbe3ed; border-radius: 3px; }
    .petugas-section-title { padding: 10px 12px; background: var(--sip-sidebar-bg); color: #fff; font-size: 13px; font-weight: 700; }
    .petugas-fields { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px 20px; padding: 16px; }
    .petugas-field { display: flex; flex-direction: column; }
    .petugas-field label { display: block; margin-bottom: 6px; color: #334155; font-size: 11px; font-weight: 700; }
    .petugas-field input, .petugas-field select { width: 100%; height: 40px; border: 1px solid #cbd5e1; border-radius: 8px; background: #fff; padding: 0 12px; color: #334155; font-size: 12px; }
    .petugas-field input:focus, .petugas-field select:focus { border-color: var(--sip-primary); outline: 0; box-shadow: 0 0 0 3px rgba(29, 97, 232, .12); }
    .petugas-field input::placeholder { color: #94a3b8; }
    .petugas-field-wide { grid-column: 1 / -1; }
    .petugas-field-note { margin-top: 6px; color: #64748b; font-size: 11px; }
    .petugas-field-error { margin-top: 6px; color: #b91c1c; font-size: 11px; font-weight: 600; }
    .petugas-form-actions { display: flex; justify-content: flex-end; gap: 8px; padding: 0 16px 16px; }
    .petugas-btn { display: inline-flex; align-items: center; justify-content: center; min-height: 38px; padding: 0 16px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; cursor: pointer; }
    .petugas-btn-primary { border: 1px solid var(--sip-primary); background: var(--sip-primary); color: #fff; }
    .petugas-btn-primary:hover { background: var(--sip-primary-hover); }
    .petugas-btn-secondary { border: 1px solid #cbd5e1; background: #fff; color: #334155; }
    .petugas-btn-secondary:hover { background: #f8fafc; }
    @media (max-width: 640px) { .petugas-form-page { padding: 12px; } .petugas-form-panel { width: 100%; } .petugas-form-header { align-items: flex-start; flex-direction: column; padding: 16px; } .petugas-form-title { font-size: 19px; } .petugas-form-content { padding: 16px; } .petugas-fields { grid-template-columns: 1fr; padding: 14px; } .petugas-form-actions { align-items: stretch; flex-direction: column-reverse; padding: 0 14px 14px; } .petugas-btn { width: 100%; } }
</style>

<main class="sipper-content">
    @include('layouts.header', ['pageTitle' => isset($user) ? 'Edit Petugas' : 'Tambah Petugas'])
    <div class="petugas-form-page">
        <div class="petugas-form-panel">

            <div class="petugas-form-header">
                <div>
                    <p class="petugas-kicker">Administrasi</p>
                    <h1 class="petugas-form-title">{{ isset($user) ? 'Edit Petugas' : 'Tambah Petugas' }}</h1>
                    <p class="petugas-form-subtitle">
                        {{ isset($user) ? 'Perbarui data akun petugas.' : 'Tambahkan akun petugas baru ke sistem.' }}
                    </p>
                </div>
            </div>

            @if($errors->any())
                <div class="petugas-error">
                    <p>Data belum dapat disimpan.</p>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="petugas-form-content">
                <form method="POST" action="{{ isset($user) ? route('user.update', $user) : route('user.store') }}">
                    @csrf
                    @if(isset($user)) @method('PUT') @endif

                    <section class="petugas-form-section">
                        <div class="petugas-section-title">
                            {{ isset($user) ? 'Data Petugas' : 'Data Petugas Baru' }}
                        </div>

                        <div class="petugas-fields">
                            <div class="petugas-field petugas-field-wide">
                                <label for="name">Nama <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required placeholder="Masukkan nama petugas">
                                @error('name')
                                    <div class="petugas-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="petugas-field">
                                <label for="username">Username <span class="text-red-500">*</span></label>
                                <input type="text" id="username" name="username" value="{{ old('username', $user->username ?? '') }}" required placeholder="Masukkan username">
                                @error('username')
                                    <div class="petugas-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="petugas-field">
                                <label for="email">Email <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required placeholder="Masukkan email">
                                @error('email')
                                    <div class="petugas-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="petugas-field petugas-field-wide">
                                <label for="password">{{ isset($user) ? 'Password Baru (opsional)' : 'Password' }} {{ !isset($user) ? '<span class="text-red-500">*</span>' : '' }}</label>
                                <input type="password" id="password" name="password" {{ isset($user) ? '' : 'required' }} minlength="8" placeholder="{{ isset($user) ? 'Kosongkan jika tidak diubah' : 'Minimal 8 karakter' }}">
                                @if(isset($user))
                                    <div class="petugas-field-note">Kosongkan jika tidak ingin mengubah password.</div>
                                @else
                                    <div class="petugas-field-note">Password minimal 8 karakter.</div>
                                @endif
                                @error('password')
                                    <div class="petugas-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            @if(isset($user))
                                <div class="petugas-field petugas-field-wide">
                                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" minlength="8" placeholder="Ulangi password baru">
                                </div>
                            @endif
                        </div>

                        <div class="petugas-form-actions">
                            <a href="{{ route('user.index') }}" class="petugas-btn petugas-btn-secondary">Batal</a>
                            <button type="submit" class="petugas-btn petugas-btn-primary">
                                {{ isset($user) ? 'Simpan Perubahan' : 'Simpan Petugas' }}
                            </button>
                        </div>
                    </section>
                </form>
            </div>

        </div>
    </div>
</main>
