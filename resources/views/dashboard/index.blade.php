<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Sistem Rekap</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root{--primary:#2563eb;--primary-dark:#1d4ed8;--bg:#f5f7fb;--text:#172033;--muted:#718096;--line:#e7ebf2;--white:#fff;}
        *{box-sizing:border-box}
        body{margin:0;background:var(--bg);color:var(--text);font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif}
        a{text-decoration:none;color:inherit}
        .app{min-height:100vh;display:flex}
        .main{margin-left:250px;min-width:0;width:calc(100% - 250px)}
        .content{max-width:1440px;margin:0 auto;padding:30px 34px 42px}
        .hero{display:flex;justify-content:space-between;gap:24px;align-items:flex-end;margin-bottom:24px}.eyebrow{font-size:11px;font-weight:800;color:var(--primary);text-transform:uppercase;letter-spacing:.1em}.hero h1{font-size:28px;line-height:1.15;margin:6px 0 7px;letter-spacing:-.02em}.hero p{margin:0;color:var(--muted);font-size:13px}.primary-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;background:var(--primary);color:#fff;border:0;border-radius:10px;padding:11px 16px;font-size:12px;font-weight:700;box-shadow:0 7px 18px rgba(37,99,235,.18)}.primary-btn:hover{background:var(--primary-dark)}
        .stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px;margin-bottom:24px}.stat{background:#fff;border:1px solid var(--line);border-radius:14px;padding:19px 20px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 3px 12px rgba(20,32,56,.025)}.stat.primary{background:linear-gradient(135deg,#2563eb,#1d4ed8);border-color:#2563eb;color:#fff}.stat-label{font-size:11px;font-weight:700;color:#8a95a6}.stat.primary .stat-label{color:#dbeafe}.stat-value{font-size:28px;font-weight:800;line-height:1;margin-top:7px}.stat-icon{width:42px;height:42px;border-radius:11px;background:#f1f5ff;color:var(--primary);display:grid;place-items:center;font-weight:800}.stat.primary .stat-icon{background:rgba(255,255,255,.16);color:#fff}
        .section{background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 3px 12px rgba(20,32,56,.025)}.section-head{padding:19px 20px;border-bottom:1px solid var(--line);display:flex;justify-content:space-between;align-items:center;gap:15px}.section-head h2{font-size:15px;margin:0}.section-head p{font-size:11px;color:#8a95a6;margin:4px 0 0}.link{font-size:11px;color:var(--primary);font-weight:700}
        .categories{padding:18px 20px;display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:10px}.category{border:1px solid var(--line);border-radius:11px;padding:14px;background:#fbfcfe}.category:hover{border-color:#cbd8f4;background:#f8faff}.category-top{display:flex;align-items:center;justify-content:space-between}.dot{width:8px;height:8px;border-radius:50%;background:#3b82f6}.category:nth-child(2) .dot{background:#8b5cf6}.category:nth-child(3) .dot{background:#10b981}.category:nth-child(4) .dot{background:#f59e0b}.category:nth-child(5) .dot{background:#ef4444}.category:nth-child(6) .dot{background:#06b6d4}.category-name{font-size:11px;color:#667085;font-weight:700;margin-top:10px}.category-value{font-size:21px;font-weight:800;margin-top:4px}
        .lower{display:grid;grid-template-columns:minmax(0,1.7fr) minmax(280px,.8fr);gap:18px;margin-top:18px}.table-wrap{overflow-x:auto}.table{width:100%;border-collapse:collapse;font-size:11px}.table th{background:#fafbfc;color:#8a95a6;text-align:left;font-size:9px;text-transform:uppercase;letter-spacing:.06em;padding:11px 18px;border-bottom:1px solid var(--line)}.table td{padding:13px 18px;border-bottom:1px solid #f0f2f6;color:#566174;white-space:nowrap}.table tr:last-child td{border-bottom:0}.table td.name{color:#273244;font-weight:700}.badge{display:inline-block;padding:4px 8px;border-radius:7px;background:#eff5ff;color:#3566c6;font-size:9px;font-weight:800}
        .quick{padding:18px 20px;display:grid;gap:9px}.quick a{display:flex;align-items:center;justify-content:space-between;border:1px solid var(--line);border-radius:10px;padding:12px 13px;font-size:11px;font-weight:700;color:#4b5565}.quick a:hover{background:#f8faff;border-color:#cbd8f4;color:var(--primary)}.quick .q-left{display:flex;align-items:center;gap:9px}.q-icon{width:28px;height:28px;border-radius:8px;background:#eff5ff;color:var(--primary);display:grid;place-items:center;font-size:12px}.arrow{color:#a1aaba}
        .footer{margin-top:22px;color:#9aa3b2;font-size:10px;text-align:center}
        @media(max-width:1100px){.categories{grid-template-columns:repeat(3,minmax(0,1fr))}.lower{grid-template-columns:1fr}.main{margin-left:220px;width:calc(100% - 220px)}}
        @media(max-width:760px){.app{display:flex}.main{margin-left:220px;width:calc(100% - 220px)}.sidebar-bottom{position:static;margin-top:22px}.nav{grid-template-columns:1fr}.nav-title{margin-top:5px}.content{padding:22px 16px}.hero{align-items:flex-start;flex-direction:column}.hero h1{font-size:24px}.stats{grid-template-columns:1fr}.categories{grid-template-columns:repeat(2,minmax(0,1fr))}}
        @media(max-width:420px){.categories{grid-template-columns:1fr}.section-head{align-items:flex-start;flex-direction:column}}
    </style>
</head>
<body>
<div class="app">
    @include('layouts.sidebar')

    <main class="sipper-content">
        @include('layouts.header', ['pageTitle' => 'Dashboard'])

        <div class="content">
            <section class="hero">
                <div><div class="eyebrow">Dashboard Utama</div><h1>Ringkasan Rekap Pelayanan</h1><p>Pantau seluruh data KK, Akta, KIA, KTP, Surat Pindah, dan Perekaman.</p></div>
                <a href="{{ route('permohonan.create') }}" class="primary-btn">＋ Input Rekap Baru</a>
            </section>

            <section class="stats">
                <div class="stat primary"><div><div class="stat-label">TOTAL SELURUH REKAP</div><div class="stat-value">{{ number_format($totalPermohonan) }}</div></div><div class="stat-icon">▤</div></div>
                <div class="stat"><div><div class="stat-label">REKAP HARI INI</div><div class="stat-value">{{ number_format($permohonanHariIni) }}</div></div><div class="stat-icon">◷</div></div>
                <div class="stat"><div><div class="stat-label">REKAP BULAN INI</div><div class="stat-value">{{ number_format($permohonanBulanIni) }}</div></div><div class="stat-icon">▦</div></div>
            </section>

            <section class="section">
                <div class="section-head"><div><h2>Rekap Berdasarkan Jenis</h2><p>Jumlah data yang sudah dicatat berdasarkan pelayanan.</p></div><a class="link" href="{{ route('permohonan.recap') }}">Lihat rekap →</a></div>
                <div class="categories">
                    @foreach($categoryTotals as $item)
                        <div class="category"><div class="category-top"><span class="dot"></span><span style="font-size:10px;color:#a0a8b6">data</span></div><div class="category-name">{{ $item['label'] }}</div><div class="category-value">{{ number_format($item['total']) }}</div></div>
                    @endforeach
                </div>
            </section>

            <div class="lower">
                <section class="section">
                    <div class="section-head"><div><h2>Data Rekap Terbaru</h2><p>Data terakhir yang masuk ke sistem.</p></div><a class="link" href="{{ route('permohonan.index') }}">Lihat semua →</a></div>
                    <div class="table-wrap"><table class="table"><thead><tr><th>Tanggal</th><th>Nama</th><th>Jenis</th><th>Desa</th><th>Kecamatan</th></tr></thead><tbody>
                    @forelse($recent as $row)
                        <tr><td>{{ $row->tanggal_permohonan?->format('d/m/Y') }}</td><td class="name">{{ $row->nama_pemohon }}</td><td><span class="badge">{{ $row->jenisPelayanan?->kelompokPelayanan?->kode ?? '-' }}</span></td><td>{{ $row->desa?->nama_desa ?? '-' }}</td><td>{{ $row->kecamatan?->nama_kecamatan ?? '-' }}</td></tr>
                    @empty
                        <tr><td colspan="5" style="text-align:center;padding:35px;color:#9aa3b2">Belum ada data rekap.</td></tr>
                    @endforelse
                    </tbody></table></div>
                </section>

                <section class="section">
                    <div class="section-head"><div><h2>Akses Cepat</h2><p>Menu yang sering digunakan.</p></div></div>
                    <div class="quick">
                        <a href="{{ route('permohonan.create') }}"><span class="q-left"><span class="q-icon">＋</span>Input rekap baru</span><span class="arrow">›</span></a>
                        <a href="{{ route('permohonan.index') }}"><span class="q-left"><span class="q-icon">▤</span>Daftar semua rekap</span><span class="arrow">›</span></a>
                        <a href="{{ route('permohonan.recap') }}"><span class="q-left"><span class="q-icon">▥</span>Rekapitulasi</span><span class="arrow">›</span></a>
                        <a href="{{ route('profile.show') }}"><span class="q-left"><span class="q-icon">♙</span>Profil saya</span><span class="arrow">›</span></a>
                        <form method="POST" action="{{ route('logout') }}" style="margin:0">@csrf<button type="submit" style="width:100%;display:flex;align-items:center;justify-content:space-between;border:1px solid #fee2e2;border-radius:10px;padding:12px 13px;background:#fff7f7;color:#dc2626;font-size:11px;font-weight:700;cursor:pointer"><span class="q-left"><span class="q-icon" style="background:#fee2e2;color:#dc2626">↪</span>Keluar</span><span class="arrow">›</span></button></form>
                    </div>
                </section>
            </div>
            <div class="footer">Sistem Rekap Dispenduk · Dashboard</div>
        </div>
    </main>
</div>
</body>
</html>
