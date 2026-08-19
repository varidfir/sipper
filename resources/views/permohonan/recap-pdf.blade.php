<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Permohonan</title>
    <style>
        @page { margin: 28px 30px; }
        body { color: #1e293b; font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        .header { border-bottom: 2px solid #1d61e8; margin-bottom: 18px; padding-bottom: 10px; }
        .eyebrow { color: #1d61e8; font-size: 8px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; }
        h1 { color: #0f172a; font-size: 19px; margin: 4px 0; }
        .meta { color: #64748b; font-size: 9px; }
        .summary { background: #eff6ff; border: 1px solid #bfdbfe; margin-bottom: 16px; padding: 10px 12px; }
        .summary-label { color: #2563eb; font-size: 8px; font-weight: bold; text-transform: uppercase; }
        .summary-value { color: #0f172a; font-size: 10px; font-weight: bold; margin-top: 4px; }
        table { border-collapse: collapse; width: 100%; }
        th { background: #f1f5f9; color: #475569; font-size: 8px; text-align: left; text-transform: uppercase; }
        th, td { border: 1px solid #dbe3ed; padding: 8px 9px; }
        td.number, th.number { text-align: right; }
        tfoot td { background: #f8fafc; font-weight: bold; }
        .empty { color: #64748b; padding: 24px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div class="eyebrow">Sistem Rekap</div>
        <h1>Rekapitulasi Permohonan</h1>
        <div class="meta">Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }}</div>
    </div>

    <div class="summary">
        <div class="summary-label">Filter laporan</div>
        <div class="summary-value">
            Tahun {{ $year }}
            @if($month) - {{ $months[(int) $month] }} @else - Semua Bulan @endif
            - {{ $selectedKelompok?->kode ?? 'Semua Kategori' }}
        </div>
    </div>

    @if($data->count())
        <table>
            <thead>
                <tr>
                    <th style="width: 12%;">No</th>
                    <th>Periode</th>
                    <th class="number">Jumlah Permohonan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $item)
                    @php $tanggal = \Carbon\Carbon::parse($item->period); @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($period === 'yearly')
                                {{ $tanggal->format('Y') }}
                            @elseif($period === 'monthly')
                                {{ $tanggal->translatedFormat('F Y') }}
                            @else
                                {{ $tanggal->translatedFormat('d F Y') }}
                            @endif
                        </td>
                        <td class="number">{{ $item->total }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="number">Total</td>
                    <td class="number">{{ $data->sum('total') }}</td>
                </tr>
            </tfoot>
        </table>
    @else
        <div class="empty">Tidak ditemukan data berdasarkan filter yang dipilih.</div>
    @endif
</body>
</html>
