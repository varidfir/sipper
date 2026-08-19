@vite(['resources/css/app.css', 'resources/js/app.js'])
@include('layouts.sidebar')

<style>
    .desa-page { min-height: 100vh; padding: 18px clamp(16px, 3vw, 32px) 32px; background: var(--sip-bg); }
    .desa-panel { max-width: 1360px; margin: 0 auto; overflow: hidden; border: 1px solid #dbe3ed; border-radius: 3px; background: #fff; box-shadow: 0 1px 3px rgba(15, 23, 42, .04); }
    .desa-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 18px 20px; border-bottom: 1px solid #dbe3ed; }
    .desa-kicker { margin: 0 0 4px; color: var(--sip-primary); font-size: 10px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
    .desa-title { margin: 0; color: #0f172a; font-size: 22px; line-height: 1.2; }
    .desa-subtitle { margin: 5px 0 0; color: #64748b; font-size: 12px; }
    .desa-actions { display: flex; gap: 8px; }
    .desa-button { display: inline-flex; align-items: center; justify-content: center; min-height: 35px; padding: 0 14px; border-radius: 3px; font-size: 12px; font-weight: 700; text-decoration: none; }
    .desa-button-primary { border: 1px solid var(--sip-primary); background: var(--sip-primary); color: #fff; }
    .desa-button-primary:hover { background: var(--sip-primary-hover); }
    .desa-button-secondary { border: 1px solid #cbd5e1; background: #fff; color: #334155; }
    .desa-button-secondary:hover { background: #f8fafc; }
    .desa-alert { margin: 14px 20px 0; padding: 10px 12px; border: 1px solid var(--sip-primary-border); border-radius: 3px; background: var(--sip-primary-soft); color: var(--sip-primary); font-size: 12px; }
    .desa-alert strong { display: block; margin-bottom: 2px; }
    .desa-content { padding: 18px 20px 20px; }
    .desa-list-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 8px; }
    .desa-list-head h2 { margin: 0; color: #0f172a; font-size: 14px; }
    .desa-count { color: #64748b; font-size: 11px; font-weight: 700; }
    .desa-table-wrap { overflow-x: auto; border: 1px solid #dbe3ed; border-radius: 3px; }
    .desa-table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .desa-table th { padding: 10px 12px; border-bottom: 1px solid #dbe3ed; background: var(--sip-primary-soft); color: var(--sip-primary-hover); font-size: 10px; text-align: left; text-transform: uppercase; }
    .desa-table td { padding: 11px 12px; border-bottom: 1px solid #edf2f7; color: #475569; }
    .desa-table tr:last-child td { border-bottom: 0; }
    .desa-table tbody tr:hover { background: #f4f8ff; }
    .desa-number { width: 60px; color: #94a3b8 !important; }
    .desa-name { color: #1f2937 !important; font-weight: 700; }
    .desa-district { color: #64748b !important; }
    .desa-row-actions { display: flex; justify-content: flex-end; gap: 6px; }
    .desa-action { display: inline-flex; align-items: center; justify-content: center; min-height: 29px; padding: 0 10px; border-radius: 3px; font-size: 11px; font-weight: 700; text-decoration: none; }
    .desa-edit { border: 1px solid var(--sip-primary-border); background: var(--sip-primary-soft); color: var(--sip-primary); }
    .desa-edit:hover { background: #dbeafe; }
    .desa-delete { border: 1px solid #fecaca; background: #fff1f2; color: #b91c1c; cursor: pointer; }
    .desa-delete:hover { background: #fee2e2; }
    .desa-empty { padding: 38px 16px !important; color: #64748b !important; text-align: center; }
    @media (max-width: 640px) { .desa-page { padding: 12px; } .desa-panel { width: 100%; } .desa-header { align-items: flex-start; flex-direction: column; padding: 16px; } .desa-title { font-size: 19px; } .desa-actions { width: 100%; } .desa-button { flex: 1; padding: 0 8px; } .desa-content { padding: 16px; } .desa-list-head { align-items: flex-start; flex-direction: column; } .desa-table { min-width: 620px; } }
</style>

<main class="sipper-content">
    @include('layouts.header', ['pageTitle' => 'Wilayah Desa/Kelurahan'])
    <div class="desa-page">
        <div class="desa-panel">

            {{-- HEADER --}}
            <div class="desa-header">
                    <div>
                        <p class="desa-kicker">
                            ADMINISTRASI
                        </p>
                        <h1 class="desa-title">
                            Data Desa/Kelurahan
                        </h1>
                        <p class="desa-subtitle">
                            Kelola data desa dan kelurahan dalam wilayah kecamatan.
                        </p>
                    </div>
                    <div class="desa-actions">
                        <a href="{{ route('desa.create') }}" class="desa-button desa-button-primary">
                            + Tambah
                        </a>
                    </div>
            </div>

            {{-- NOTIFIKASI --}}
            @if(session('status'))
                <div class="desa-alert">
                    <strong>Berhasil</strong>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{-- DAFTAR DESA --}}
            <div class="desa-content">
                <section>
                    <div class="desa-list-head">
                        <h2>Daftar Desa/Kelurahan</h2>
                        <span class="desa-count">{{ $desas->count() }} desa/kelurahan terdaftar</span>
                    </div>

                    <div class="desa-table-wrap">
                        <table class="desa-table">
                            <thead><tr><th class="desa-number">No</th><th>Nama Desa/Kelurahan</th><th>Kecamatan</th><th style="text-align:right">Aksi</th></tr></thead>
                            <tbody>
                        @forelse($desas as $desa)
                            <tr>
                                <td class="desa-number">{{ $loop->iteration }}</td>
                                <td class="desa-name">{{ $desa->nama_desa }}</td>
                                <td class="desa-district">{{ $desa->kecamatan->nama_kecamatan ?? '-' }}</td>
                                <td><div class="desa-row-actions">
                                    <a href="{{ route('desa.edit', $desa) }}" class="desa-action desa-edit">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('desa.destroy', $desa) }}" onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="desa-action desa-delete">
                                            Hapus
                                        </button>
                                    </form>
                                </div></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="desa-empty">Belum ada data desa/kelurahan.</td></tr>
                        @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

        </div>
    </div>
</main>
