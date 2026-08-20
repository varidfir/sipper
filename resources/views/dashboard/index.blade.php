<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SIPPER</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="dashboard-app">
    @include('layouts.sidebar')

    <main class="sipper-content">
        @include('layouts.header', ['pageTitle' => 'Dashboard'])

        <div class="dashboard-page">
            <div class="dashboard-main-panel">
                <section class="dashboard-heading">
                    <div>
                        <span class="dashboard-kicker">Ringkasan administrasi</span>
                        <h1>Dashboard utama</h1>
                        <p>Pantau aktivitas pelayanan dan data rekap secara menyeluruh.</p>
                    </div>
                    <a href="{{ route('permohonan.create') }}" class="dashboard-primary-action"><span aria-hidden="true">+</span> Input rekap baru</a>
                </section>

                <section class="dashboard-stats" aria-label="Ringkasan rekap">
                    <div class="dashboard-stat dashboard-stat-primary"><div><span>Total seluruh rekap</span><strong>{{ number_format($totalPermohonan) }}</strong><small>Akumulasi seluruh pelayanan</small></div><div class="dashboard-stat-icon" aria-hidden="true">▤</div></div>
                    <div class="dashboard-stat"><div><span>Rekap hari ini</span><strong>{{ number_format($permohonanHariIni) }}</strong><small>Data masuk hari ini</small></div><div class="dashboard-stat-icon" aria-hidden="true">◷</div></div>
                    <div class="dashboard-stat"><div><span>Rekap bulan ini</span><strong>{{ number_format($permohonanBulanIni) }}</strong><small>Data masuk bulan berjalan</small></div><div class="dashboard-stat-icon" aria-hidden="true">▦</div></div>
                </section>

                <section class="dashboard-panel">
                    <div class="dashboard-panel-heading"><div><h2>Rekap berdasarkan jenis</h2><p>Jumlah data yang tercatat untuk setiap kelompok pelayanan.</p></div><a href="{{ route('permohonan.recap') }}">Lihat rekap <span aria-hidden="true">→</span></a></div>
                    <div class="dashboard-categories">
                        @foreach($categoryTotals as $item)
                            <div class="dashboard-category"><span class="dashboard-category-dot" aria-hidden="true"></span><span class="dashboard-category-label">{{ $item['label'] }}</span><strong>{{ number_format($item['total']) }}</strong></div>
                        @endforeach
                    </div>
                </section>

                <div class="dashboard-lower">
                    <section class="dashboard-panel">
                        <div class="dashboard-panel-heading"><div><h2>Data rekap terbaru</h2><p>Data terakhir yang masuk ke sistem.</p></div><a href="{{ route('permohonan.index') }}">Lihat semua <span aria-hidden="true">→</span></a></div>
                        <div class="dashboard-table-wrap"><table class="dashboard-table"><thead><tr><th>Tanggal</th><th>Nama pemohon</th><th>Jenis</th><th>Wilayah</th></tr></thead><tbody>
                        @forelse($recent as $row)
                            <tr><td>{{ $row->tanggal_permohonan?->format('d/m/Y') }}</td><td class="dashboard-table-name">{{ $row->nama_pemohon }}</td><td><span class="dashboard-badge">{{ $row->jenisPelayanan?->kelompokPelayanan?->kode ?? '-' }}</span></td><td>{{ $row->desa?->nama_desa ?? '-' }}, {{ $row->kecamatan?->nama_kecamatan ?? '-' }}</td></tr>
                        @empty
                            <tr><td colspan="4" class="dashboard-empty">Belum ada data rekap.</td></tr>
                        @endforelse
                        </tbody></table></div>
                    </section>

                    <section class="dashboard-panel dashboard-actions-panel">
                        <div class="dashboard-panel-heading"><div><h2>Akses cepat</h2><p>Menu yang sering digunakan.</p></div></div>
                        <div class="dashboard-actions">
                            <a href="{{ route('permohonan.create') }}"><span><b>+</b>Input rekap baru</span><strong aria-hidden="true">→</strong></a>
                            <a href="{{ route('permohonan.index') }}"><span><b>▤</b>Daftar semua rekap</span><strong aria-hidden="true">→</strong></a>
                            <a href="{{ route('permohonan.recap') }}"><span><b>▥</b>Rekapitulasi</span><strong aria-hidden="true">→</strong></a>
                            <a href="{{ route('profile.show') }}"><span><b>♙</b>Profil saya</span><strong aria-hidden="true">→</strong></a>
                        </div>
                    </section>
                </div>

                <div class="dashboard-footer">SIPPER · Sistem Informasi Pelayanan dan Perekaman</div>
            </div>
        </div>
    </main>
</div>
</body>
</html>
