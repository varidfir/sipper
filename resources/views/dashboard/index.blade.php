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

        <div class="page-shell">
            <div class="form-page-container dashboard-main-panel">
                <section class="form-header dashboard-heading">
                    <div class="form-title-group">
                        <h1>Dashboard Utama</h1>
                        <p>Ringkasan pelayanan administrasi kependudukan Kabupaten Magetan.</p>
                    </div>
                    <a href="{{ route('permohonan.create') }}" class="primary-btn">+ Input Rekap Baru</a>
                </section>

                <section class="dashboard-service-banner">
                    <strong>Ringkasan Pelayanan</strong>
                    <span>Pantau aktivitas dan data rekap secara menyeluruh</span>
                </section>

                <section class="dashboard-stats" aria-label="Ringkasan rekap">
                    <div class="dashboard-stat dashboard-stat-primary"><div><span>Total seluruh rekap</span><strong>{{ number_format($totalPermohonan) }}</strong><small>Akumulasi seluruh pelayanan</small></div><div class="dashboard-stat-icon" aria-hidden="true">▤</div></div>
                    <div class="dashboard-stat"><div><span>Rekap hari ini</span><strong>{{ number_format($permohonanHariIni) }}</strong><small>Data masuk hari ini</small></div><div class="dashboard-stat-icon" aria-hidden="true">◷</div></div>
                    <div class="dashboard-stat"><div><span>Rekap bulan ini</span><strong>{{ number_format($permohonanBulanIni) }}</strong><small>Data masuk bulan berjalan</small></div><div class="dashboard-stat-icon" aria-hidden="true">▦</div></div>
                </section>

                <section class="dashboard-panel dashboard-monthly-panel">
                    <div class="dashboard-panel-heading">
                        <div>
                            <h2>Permohonan per bulan</h2>
                            <p>Jumlah permohonan pada tahun {{ now()->year }}.</p>
                        </div>
                        <strong class="dashboard-chart-total">{{ number_format(array_sum($monthlyTotals)) }} total</strong>
                    </div>
                    <div class="dashboard-chart" aria-label="Grafik permohonan per bulan tahun {{ now()->year }}">
                        @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'] as $monthIndex => $monthLabel)
                            @php
                                $monthTotal = $monthlyTotals[$monthIndex + 1] ?? 0;
                                $chartHeight = $monthTotal ? max(8, ($monthTotal / max($monthlyTotals)) * 100) : 3;
                            @endphp
                            <div class="dashboard-chart-column">
                                <span class="dashboard-chart-value">{{ $monthTotal ?: '' }}</span>
                                <div class="dashboard-chart-track">
                                    <span class="dashboard-chart-bar" @style(['height' => $chartHeight . '%'])></span>
                                </div>
                                <span class="dashboard-chart-label">{{ $monthLabel }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="dashboard-panel dashboard-service-panel">
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
                        <div class="dashboard-table-wrap"><table class="dashboard-table sipper-data-table"><thead><tr><th>Tanggal</th><th>Nama pemohon</th><th>Jenis</th><th>Wilayah</th></tr></thead><tbody>
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
