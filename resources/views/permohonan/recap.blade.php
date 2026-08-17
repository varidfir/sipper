<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi | Sistem Rekap</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root{--primary:#2563eb;--primary-dark:#1d4ed8;--bg:#f5f7fb;--text:#172033;--muted:#718096;--line:#e7ebf2;--white:#fff;}
        *{box-sizing:border-box}
        body{margin:0;background:var(--bg);color:var(--text);font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif}
        a{text-decoration:none;color:inherit}
        .app{min-height:100vh;display:flex}
        .main{margin-left:250px;min-width:0;width:calc(100% - 250px)}
        .topbar{height:74px;background:#fff;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;padding:0 34px;position:sticky;top:0;z-index:10}
        .crumb{font-size:12px;color:#8b95a5}.crumb strong{color:#273244}.top-actions{display:flex;align-items:center;gap:10px}.today{font-size:11px;color:#8791a2;background:#f7f8fb;border:1px solid var(--line);padding:9px 12px;border-radius:10px}
        .content{max-width:1440px;margin:0 auto;padding:30px 34px 42px}
        .hero{display:flex;justify-content:space-between;gap:24px;align-items:flex-end;margin-bottom:24px}.eyebrow{font-size:11px;font-weight:800;color:var(--primary);text-transform:uppercase;letter-spacing:.1em}.hero h1{font-size:28px;line-height:1.15;margin:6px 0 7px;letter-spacing:-.02em}.hero p{margin:0;color:var(--muted);font-size:13px}.primary-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;background:var(--primary);color:#fff;border:0;border-radius:10px;padding:11px 16px;font-size:12px;font-weight:700;box-shadow:0 7px 18px rgba(37,99,235,.18)}.primary-btn:hover{background:var(--primary-dark)}
        .secondary-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;background:#fff;color:var(--text);border:1px solid var(--line);border-radius:10px;padding:11px 16px;font-size:12px;font-weight:700}.secondary-btn:hover{background:#f8fafc;border-color:#cbd8f4;color:var(--primary)}
        .stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px;margin-bottom:24px}.stat{background:#fff;border:1px solid var(--line);border-radius:14px;padding:19px 20px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 3px 12px rgba(20,32,56,.025)}.stat.primary{background:linear-gradient(135deg,#2563eb,#1d4ed8);border-color:#2563eb;color:#fff}.stat-label{font-size:11px;font-weight:700;color:#8a95a6}.stat.primary .stat-label{color:#dbeafe}.stat-value{font-size:28px;font-weight:800;line-height:1;margin-top:7px}.stat-icon{width:42px;height:42px;border-radius:11px;background:#f1f5ff;color:var(--primary);display:grid;place-items:center;font-weight:800}.stat.primary .stat-icon{background:rgba(255,255,255,.16);color:#fff}
        .section{background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 3px 12px rgba(20,32,56,.025)}.section-head{padding:19px 20px;border-bottom:1px solid var(--line);display:flex;justify-content:space-between;align-items:center;gap:15px}.section-head h2{font-size:15px;margin:0}.section-head p{font-size:11px;color:#8a95a6;margin:4px 0 0}.link{font-size:11px;color:var(--primary);font-weight:700}
        .table-wrap{overflow-x:auto}.table{width:100%;border-collapse:collapse;font-size:11px}.table th{background:#fafbfc;color:#8a95a6;text-align:left;font-size:9px;text-transform:uppercase;letter-spacing:.06em;padding:11px 18px;border-bottom:1px solid var(--line)}.table td{padding:13px 18px;border-bottom:1px solid #f0f2f6;color:#566174;white-space:nowrap}.table tr:last-child td{border-bottom:0}.table td.name{color:#273244;font-weight:700}.badge{display:inline-block;padding:4px 8px;border-radius:7px;background:#eff5ff;color:#3566c6;font-size:9px;font-weight:800}
        .filter-box{background:#fff;border:1px solid var(--line);border-radius:14px;padding:19px 20px;margin-bottom:24px;box-shadow:0 3px 12px rgba(20,32,56,.025)}.filter-title{font-size:11px;font-weight:700;color:#8a95a6;margin-bottom:12px;text-transform:uppercase;letter-spacing:.06em}.filter-active{font-size:14px;font-weight:700;color:var(--text)}.filter-badge{display:inline-flex;align-items:center;padding:4px 10px;background:#f1f5ff;color:var(--primary);border-radius:8px;font-size:10px;font-weight:700;margin-left:8px}
        .filter-form{display:grid;grid-template-columns:1fr 1fr 1fr 1.5fr auto;gap:12px;align-items:end}.form-group label{display:block;font-size:10px;font-weight:700;color:#8a95a6;margin-bottom:6px;text-transform:uppercase;letter-spacing:.05em}.form-control{width:100%;border:1px solid #d1d5db;border-radius:8px;padding:10px 12px;font-size:12px;color:#374151;outline:none;transition:border-color .15s}.form-control:focus{border-color:var(--primary)}
        .alert{padding:12px 16px;border-radius:10px;font-size:12px;font-weight:600;margin-bottom:20px;display:flex;align-items:center;gap:10px}.alert-success{background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0}.alert-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}
        .footer{margin-top:22px;color:#9aa3b2;font-size:10px;text-align:center}
        @media(max-width:1100px){.main{margin-left:220px;width:calc(100% - 220px)}.filter-form{grid-template-columns:1fr 1fr;gap:16px}}
        @media(max-width:760px){.app{display:flex}.main{margin-left:220px;width:calc(100% - 220px)}.topbar{padding:0 18px}.today{display:none}.content{padding:22px 16px}.hero{align-items:flex-start;flex-direction:column}.hero h1{font-size:24px}.stats{grid-template-columns:1fr}.filter-form{grid-template-columns:1fr}}
        @media(max-width:420px){.section-head{align-items:flex-start;flex-direction:column}}
    </style>
</head>
<body>
<div class="app">
    @include('layouts.sidebar')

    <main class="main">
        <header class="topbar">
            <div class="crumb">Sistem Rekap <span style="margin:0 6px;color:#c1c7d0">/</span> <strong>Rekapitulasi</strong></div>
            <div class="top-actions"><span class="today">{{ now()->translatedFormat('l, d F Y') }}</span></div>
        </header>

        <div class="content">
            <section class="hero">
                <div>
                    <div class="eyebrow">Rekapitulasi</div>
                    <h1>Rekapitulasi Permohonan</h1>
                    <p>Ringkasan jumlah permohonan pelayanan berdasarkan periode.</p>
                </div>
                <div style="display:flex;gap:10px">
                    <a href="{{ route('permohonan.index') }}" class="secondary-btn">← Data Rekap</a>
                    <a href="{{ route('permohonan.export', ['format' => 'csv', 'year' => $year, 'month' => $month, 'kelompok_pelayanan_id' => $kelompokPelayananId]) }}" class="primary-btn">⇩ Export CSV</a>
                </div>
            </section>

            @if(session('status'))
                <div class="alert alert-success"><span>✓</span> {{ session('status') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error"><span>!</span> {{ session('error') }}</div>
            @endif

            <section class="filter-box">
                <form method="GET" action="{{ route('permohonan.recap') }}" class="filter-form">
                    <div class="form-group">
                        <label>Periode</label>
                        <select name="period" class="form-control">
                            <option value="daily" {{ ($period ?? 'daily') === 'daily' ? 'selected' : '' }}>Harian</option>
                            <option value="monthly" {{ ($period ?? '') === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                            <option value="yearly" {{ ($period ?? '') === 'yearly' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tahun</label>
                        <select name="year" class="form-control">
                            @for($y = now()->year; $y >= now()->year - 5; $y--)
                                <option value="{{ $y }}" {{ (int)($year ?? now()->year) === $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Bulan</label>
                        <select name="month" class="form-control">
                            <option value="">Semua Bulan</option>
                            @foreach($months as $number => $name)
                                <option value="{{ $number }}" {{ (string)($month ?? '') === (string)$number ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kelompok_pelayanan_id" class="form-control">
                            <option value="">Semua Kategori</option>
                            @foreach($kelompokPelayanans as $kelompok)
                                <option value="{{ $kelompok->id }}" {{ (string)($kelompokPelayananId ?? '') === (string)$kelompok->id ? 'selected' : '' }}>
                                    {{ $kelompok->kode === 'SURAT_PINDAH' ? 'SURAT PINDAH' : $kelompok->kode }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display:flex;gap:8px">
                        <a href="{{ route('permohonan.recap') }}" class="secondary-btn" style="padding:10px 14px">Reset</a>
                        <button type="submit" class="primary-btn" style="padding:10px 16px;border:0;cursor:pointer">Filter</button>
                    </div>
                </form>
            </section>

            <section class="stats">
                <div class="stat primary">
                    <div>
                        <div class="stat-label">TOTAL PERMOHONAN</div>
                        <div class="stat-value">{{ number_format($data->sum('total')) }}</div>
                    </div>
                    <div class="stat-icon">▤</div>
                </div>
                <div class="stat">
                    <div>
                        <div class="stat-label">JUMLAH PERIODE</div>
                        <div class="stat-value">{{ $data->count() }}</div>
                    </div>
                    <div class="stat-icon">▦</div>
                </div>
                <div class="stat">
                    <div>
                        <div class="stat-label">RATA-RATA</div>
                        <div class="stat-value">{{ $data->count() > 0 ? number_format($data->avg('total'), 0, ',', '.') : 0 }}</div>
                    </div>
                    <div class="stat-icon">◷</div>
                </div>
            </section>

            <section class="section">
                <div class="section-head">
                    <div>
                        <h2>Hasil Rekapitulasi</h2>
                        <p>
                            @php
                                $selectedKelompok = $kelompokPelayananId ? $kelompokPelayanans->firstWhere('id', $kelompokPelayananId) : null;
                                $kelompokName = $selectedKelompok ? ($selectedKelompok->kode === 'SURAT_PINDAH' ? 'SURAT PINDAH' : $selectedKelompok->kode) : 'Semua Kategori';
                                $monthName = $month ? $months[(int)$month] : 'Semua Bulan';
                            @endphp
                            Filter aktif: {{ $year }} • {{ $monthName }} • {{ $kelompokName }}
                        </p>
                    </div>
                    <span class="badge">{{ $data->count() }} Periode</span>
                </div>
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:50px">No</th>
                                <th>Periode</th>
                                <th style="text-align:right">Jumlah Permohonan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="name">
                                        @php
                                            $tanggal = \Carbon\Carbon::parse($item->period);
                                        @endphp
                                        @if($period === 'yearly')
                                            {{ $tanggal->format('Y') }}
                                        @elseif($period === 'monthly')
                                            {{ $tanggal->translatedFormat('F Y') }}
                                        @else
                                            {{ $tanggal->translatedFormat('d F Y') }}
                                        @endif
                                    </td>
                                    <td style="text-align:right">
                                        <span class="badge" style="font-size:11px;padding:5px 10px">{{ number_format($item->total, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align:center;padding:40px;color:#9aa3b2">
                                        <div style="font-size:24px;margin-bottom:10px">▤</div>
                                        <div style="font-weight:700;color:#566174;margin-bottom:4px">Belum ada data rekapitulasi</div>
                                        <div>Tidak ditemukan permohonan berdasarkan filter yang dipilih.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($data->count() > 0)
                            <tfoot>
                                <tr>
                                    <td colspan="2" style="text-align:right;font-weight:800;color:#273244;padding:15px 18px">Total Keseluruhan</td>
                                    <td style="text-align:right;padding:15px 18px">
                                        <span style="display:inline-block;background:var(--primary);color:#fff;padding:6px 12px;border-radius:8px;font-weight:800">{{ number_format($data->sum('total'), 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </section>

            <div class="footer">
                Sistem Rekap Dispenduk Kabupaten Magetan · Data diperbarui otomatis
            </div>
        </div>
    </main>
</div>
</body>
</html>