@vite(['resources/css/app.css', 'resources/js/app.js'])
@include('layouts.sidebar')

<style>
    .kecamatan-page { min-height: 100vh; padding: 18px clamp(16px, 3vw, 32px) 32px; background: #f4f6f9; }
    .kecamatan-panel { max-width: 1360px; margin: 0 auto; overflow: hidden; border: 1px solid #dbe3ed; border-radius: 3px; background: #fff; box-shadow: 0 1px 3px rgba(15, 23, 42, .04); }
    .kecamatan-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 18px 20px; border-bottom: 1px solid #dbe3ed; }
    .kecamatan-kicker { margin: 0 0 4px; color: #1d61e8; font-size: 10px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
    .kecamatan-title { margin: 0; color: #0f172a; font-size: 22px; line-height: 1.2; }
    .kecamatan-subtitle { margin: 5px 0 0; color: #64748b; font-size: 12px; }
    .kecamatan-actions { display: flex; gap: 8px; }
    .kecamatan-button { display: inline-flex; align-items: center; justify-content: center; min-height: 35px; padding: 0 14px; border-radius: 3px; font-size: 12px; font-weight: 700; text-decoration: none; }
    .kecamatan-button-primary { border: 1px solid #1d61e8; background: #1d61e8; color: #fff; }
    .kecamatan-button-primary:hover { background: #1752ca; }
    .kecamatan-button-secondary { border: 1px solid #cbd5e1; background: #fff; color: #334155; }
    .kecamatan-button-secondary:hover { background: #f8fafc; }
    .kecamatan-alert { margin: 14px 20px 0; padding: 10px 12px; border: 1px solid #bbf7d0; border-radius: 3px; background: #f0fdf4; color: #166534; font-size: 12px; }
    .kecamatan-alert strong { display: block; margin-bottom: 2px; }
    .kecamatan-content { padding: 18px 20px 20px; }
    .kecamatan-list-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 8px; }
    .kecamatan-list-head h2 { margin: 0; color: #0f172a; font-size: 14px; }
    .kecamatan-count { color: #64748b; font-size: 11px; font-weight: 700; }
    .kecamatan-table-wrap { overflow-x: auto; border: 1px solid #dbe3ed; border-radius: 3px; }
    .kecamatan-table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .kecamatan-table th { padding: 10px 12px; border-bottom: 1px solid #dbe3ed; background: #eff6ff; color: #1e40af; font-size: 10px; text-align: left; text-transform: uppercase; }
    .kecamatan-table td { padding: 11px 12px; border-bottom: 1px solid #edf2f7; color: #475569; }
    .kecamatan-table tr:last-child td { border-bottom: 0; }
    .kecamatan-table tbody tr:hover { background: #f8fbff; }
    .kecamatan-number { width: 60px; color: #94a3b8 !important; }
    .kecamatan-name { color: #1f2937 !important; font-weight: 700; }
    .kecamatan-row-actions { display: flex; justify-content: flex-end; gap: 6px; }
    .kecamatan-action { display: inline-flex; align-items: center; justify-content: center; min-height: 29px; padding: 0 10px; border-radius: 3px; font-size: 11px; font-weight: 700; text-decoration: none; }
    .kecamatan-edit { border: 1px solid #bfdbfe; background: #eff6ff; color: #1d4ed8; }
    .kecamatan-edit:hover { background: #dbeafe; }
    .kecamatan-delete { border: 1px solid #fecaca; background: #fff1f2; color: #b91c1c; cursor: pointer; }
    .kecamatan-delete:hover { background: #fee2e2; }
    .kecamatan-empty { padding: 38px 16px !important; color: #64748b !important; text-align: center; }
    @media (max-width: 640px) { .kecamatan-page { padding: 12px; } .kecamatan-panel { width: 100%; } .kecamatan-header { align-items: flex-start; flex-direction: column; padding: 16px; } .kecamatan-title { font-size: 19px; } .kecamatan-actions { width: 100%; } .kecamatan-button { flex: 1; padding: 0 8px; } .kecamatan-content { padding: 16px; } .kecamatan-list-head { align-items: flex-start; flex-direction: column; } .kecamatan-table { min-width: 520px; } }
</style>

<main class="sipper-content">
    @include('layouts.header', ['pageTitle' => 'Wilayah Kecamatan'])
    <div class="kecamatan-page">
        <div class="kecamatan-panel">

            {{-- HEADER --}}
            <div class="kecamatan-header">
                <div>
                        <p class="kecamatan-kicker">
                            ADMINISTRASI
                        </p>
                        <h1 class="kecamatan-title">
                            Data Kecamatan
                        </h1>
                        <p class="kecamatan-subtitle">
                            Kelola data kecamatan dalam wilayah kerja.
                        </p>
                    </div>
                    <div class="kecamatan-actions">
                        <a href="{{ route('kecamatan.create') }}" class="kecamatan-button kecamatan-button-primary">
                            + Tambah
                        </a>
                        <a href="{{ route('dashboard') }}" class="kecamatan-button kecamatan-button-secondary">
                            ← Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- NOTIFIKASI --}}
            @if(session('status'))
                <div class="kecamatan-alert">
                    <strong>Berhasil</strong>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{-- DAFTAR KECAMATAN --}}
            <div class="kecamatan-content">
                <section>
                    <div class="kecamatan-list-head">
                        <h2>Daftar Kecamatan</h2>
                        <span class="kecamatan-count">{{ $kecamatans->count() }} kecamatan terdaftar</span>
                    </div>

                    <div class="kecamatan-table-wrap">
                        <table class="kecamatan-table">
                            <thead><tr><th class="kecamatan-number">No</th><th>Nama Kecamatan</th><th style="text-align:right">Aksi</th></tr></thead>
                            <tbody>
                        @forelse($kecamatans as $kecamatan)
                            <tr>
                                <td class="kecamatan-number">{{ $loop->iteration }}</td>
                                <td class="kecamatan-name">{{ $kecamatan->nama_kecamatan }}</td>
                                <td><div class="kecamatan-row-actions">
                                    <a href="{{ route('kecamatan.edit', $kecamatan) }}" class="kecamatan-action kecamatan-edit">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('kecamatan.destroy', $kecamatan) }}" onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="kecamatan-action kecamatan-delete">
                                            Hapus
                                        </button>
                                    </form>
                                </div></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="kecamatan-empty">Belum ada data kecamatan.</td></tr>
                        @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

        </div>
    </div>
</main>
