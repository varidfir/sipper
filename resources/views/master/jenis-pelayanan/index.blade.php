@vite(['resources/css/app.css', 'resources/js/app.js'])
@include('layouts.sidebar')

<style>
    .jenis-page { min-height: 100vh; padding: 18px clamp(16px, 3vw, 32px) 32px; background: #f4f6f9; }
    .jenis-panel { max-width: 1360px; margin: 0 auto; overflow: hidden; border: 1px solid #dbe3ed; border-radius: 3px; background: #fff; box-shadow: 0 1px 3px rgba(15, 23, 42, .04); }
    .jenis-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 18px 20px; border-bottom: 1px solid #dbe3ed; }
    .jenis-kicker { margin: 0 0 4px; color: #1d61e8; font-size: 10px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
    .jenis-title { margin: 0; color: #0f172a; font-size: 22px; line-height: 1.2; }
    .jenis-subtitle { margin: 5px 0 0; color: #64748b; font-size: 12px; }
    .jenis-actions { display: flex; gap: 8px; }
    .jenis-button { display: inline-flex; align-items: center; justify-content: center; min-height: 35px; padding: 0 14px; border-radius: 3px; font-size: 12px; font-weight: 700; text-decoration: none; }
    .jenis-primary { border: 1px solid #1d61e8; background: #1d61e8; color: #fff; }
    .jenis-primary:hover { background: #1752ca; }
    .jenis-secondary { border: 1px solid #cbd5e1; background: #fff; color: #334155; }
    .jenis-secondary:hover { background: #f8fafc; }
    .jenis-alert { margin: 14px 20px 0; padding: 10px 12px; border: 1px solid #bbf7d0; border-radius: 3px; background: #f0fdf4; color: #166534; font-size: 12px; }
    .jenis-alert strong { display: block; margin-bottom: 2px; }
    .jenis-content { padding: 18px 20px 20px; }
    .jenis-list-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 8px; }
    .jenis-list-head h2 { margin: 0; color: #0f172a; font-size: 14px; }
    .jenis-count { color: #64748b; font-size: 11px; font-weight: 700; }
    .jenis-table-wrap { overflow-x: auto; border: 1px solid #dbe3ed; border-radius: 3px; }
    .jenis-table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .jenis-table th { padding: 10px 12px; border-bottom: 1px solid #dbe3ed; background: #eff6ff; color: #1e40af; font-size: 10px; text-align: left; text-transform: uppercase; }
    .jenis-table td { padding: 11px 12px; border-bottom: 1px solid #edf2f7; color: #475569; }
    .jenis-table tr:last-child td { border-bottom: 0; }
    .jenis-table tbody tr:hover { background: #f8fbff; }
    .jenis-number { width: 60px; color: #94a3b8 !important; }
    .jenis-name { color: #1f2937 !important; font-weight: 700; }
    .jenis-badge { display: inline-flex; padding: 4px 8px; border: 1px solid #bfdbfe; border-radius: 3px; background: #eff6ff; color: #1d4ed8; font-size: 10px; font-weight: 700; }
    .jenis-row-actions { display: flex; justify-content: flex-end; gap: 6px; }
    .jenis-action { display: inline-flex; align-items: center; justify-content: center; min-height: 29px; padding: 0 10px; border-radius: 3px; font-size: 11px; font-weight: 700; text-decoration: none; }
    .jenis-edit { border: 1px solid #bfdbfe; background: #eff6ff; color: #1d4ed8; }
    .jenis-edit:hover { background: #dbeafe; }
    .jenis-delete { border: 1px solid #fecaca; background: #fff1f2; color: #b91c1c; cursor: pointer; }
    .jenis-delete:hover { background: #fee2e2; }
    .jenis-empty { padding: 38px 16px !important; color: #64748b !important; text-align: center; }
    @media (max-width: 640px) { .jenis-page { padding: 12px; } .jenis-panel { width: 100%; } .jenis-header { align-items: flex-start; flex-direction: column; padding: 16px; } .jenis-title { font-size: 19px; } .jenis-actions { width: 100%; } .jenis-button { flex: 1; padding: 0 8px; } .jenis-content { padding: 16px; } .jenis-list-head { align-items: flex-start; flex-direction: column; } .jenis-table { min-width: 560px; } }
</style>

<main class="sipper-content">
    @include('layouts.header', ['pageTitle' => 'Jenis Pelayanan'])
    <div class="jenis-page">
        <div class="jenis-panel">

            {{-- HEADER --}}
            <div class="jenis-header">
                    <div>
                        <p class="jenis-kicker">
                            ADMINISTRASI
                        </p>
                        <h1 class="jenis-title">
                            Jenis Pelayanan
                        </h1>
                        <p class="jenis-subtitle">
                            Kelola jenis-jenis pelayanan yang tersedia di sistem.
                        </p>
                    </div>
                    <div class="jenis-actions">
                        <a href="{{ route('jenis-pelayanan.create') }}" class="jenis-button jenis-primary">
                            + Tambah
                        </a>
                        <a href="{{ route('dashboard') }}" class="jenis-button jenis-secondary">
                            ← Kembali
                        </a>
                    </div>
            </div>

            {{-- NOTIFIKASI --}}
            @if(session('status'))
                <div class="jenis-alert">
                    <strong>Berhasil</strong>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{-- DAFTAR JENIS PELAYANAN --}}
            <div class="jenis-content">
                <section>
                    <div class="jenis-list-head">
                        <h2>Daftar Jenis Pelayanan</h2>
                        <span class="jenis-count">{{ $jenisPelayanans->count() }} jenis pelayanan terdaftar</span>
                    </div>

                    <div class="jenis-table-wrap">
                        <table class="jenis-table">
                            <thead><tr><th class="jenis-number">No</th><th>Nama Pelayanan</th><th>Kategori</th><th style="text-align:right">Aksi</th></tr></thead>
                            <tbody>
                        @forelse($jenisPelayanans as $jenisPelayanan)
                            <tr>
                                <td class="jenis-number">{{ $loop->iteration }}</td>
                                <td class="jenis-name">{{ $jenisPelayanan->nama_pelayanan }}</td>
                                <td><span class="jenis-badge">{{ $jenisPelayanan->kategori }}</span></td>
                                <td><div class="jenis-row-actions">
                                    <a href="{{ route('jenis-pelayanan.edit', $jenisPelayanan) }}" class="jenis-action jenis-edit">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('jenis-pelayanan.destroy', $jenisPelayanan) }}" onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="jenis-action jenis-delete">
                                            Hapus
                                        </button>
                                    </form>
                                </div></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="jenis-empty">Belum ada jenis pelayanan.</td></tr>
                        @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

        </div>
    </div>
</main>
