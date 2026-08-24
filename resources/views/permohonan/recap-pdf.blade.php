<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Berita Acara</title>
    <style>
        @page { margin: 25px 28px 38px; }
        body { color: #111; font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        .letterhead { border-bottom: 3px double #111; min-height: 68px; padding-bottom: 10px; position: relative; }
        .logo { height: 68px; left: 34px; position: absolute; top: 0; width: 55px; }
        .agency { text-align: center; }
        .agency .government { font-size: 15px; font-weight: bold; }
        .agency .name { font-size: 16px; font-weight: bold; }
        .agency .address { font-size: 9px; margin-top: 4px; }
        .title { font-size: 16px; font-weight: bold; margin: 26px 0 3px; text-align: center; }
        .subtitle { font-size: 13px; font-weight: bold; text-align: center; }
        h2 { font-size: 12px; margin: 25px 0 9px; }
        .info { margin-bottom: 14px; }
        .info td { border: 0; padding: 3px 0; }
        .info .label { font-weight: bold; width: 145px; }
        .info .separator { width: 15px; }
        table { border-collapse: collapse; width: 100%; }
        th { background: #e9eef4; font-weight: bold; text-align: left; }
        th, td { border: 1px solid #9aa1a8; padding: 8px 9px; }
        th.no, td.no { text-align: center; width: 9%; }
        th.number, td.number { text-align: right; width: 20%; }
        tfoot td { border-top: 2px solid #111; font-weight: bold; }
        .summary td { border: 0; font-weight: bold; padding: 3px 0; }
        .summary .label { padding-left: 30%; width: 48%; }
        .notes { line-height: 1.55; text-align: justify; }
        .signature { margin-top: 34px; margin-left: 68%; text-align: center; }
        .signature .space { height: 48px; }
        .footer { border-top: 1px solid #aaa; bottom: -23px; font-size: 8px; left: 0; padding-top: 7px; position: fixed; right: 0; }
        .footer .page { float: right; }
        .empty { padding: 15px; text-align: center; }
    </style>
</head>
<body>
    <div class="letterhead">
        <img class="logo" src="{{ public_path('images/logo-go-digital.svg') }}" alt="Logo Kabupaten Magetan">
        <div class="agency">
            <div class="government">PEMERINTAH KABUPATEN MAGETAN</div>
            <div class="name">DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL</div>
            <div class="address">Jl. Magetan - Madiun Km. 4,5 Magetan, Jawa Timur 63391</div>
            <div class="address">Telepon (0351) 895195, Laman dispenduk.magetan.go.id, Pos-el dispenduk@magetan.go.id</div>
        </div>
    </div>

    <div class="title">LAPORAN REKAPITULASI BERITA ACARA</div>
    <div class="subtitle">PELAYANAN ADMINISTRASI KEPENDUDUKAN</div>

    <h2>INFORMASI LAPORAN</h2>
    <table class="info">
        <tr><td class="label">Dicetak Oleh</td><td class="separator">:</td><td>{{ $petugas }}</td></tr>
        <tr><td class="label">Tanggal Cetak</td><td class="separator">:</td><td>{{ $printedAt->translatedFormat('d F Y') }}</td></tr>
        <tr><td class="label">Waktu Cetak</td><td class="separator">:</td><td>{{ $printedAt->format('H.i') }} WIB</td></tr>
        <tr><td class="label">Periode Data</td><td class="separator">:</td><td>{{ $month ? $months[(int) $month] . ' ' . $year : $year }}</td></tr>
        <tr><td class="label">Kecamatan</td><td class="separator">:</td><td>Semua Kecamatan</td></tr>
        <tr><td class="label">Jenis Pelayanan</td><td class="separator">:</td><td>{{ $selectedKelompok?->nama ?? 'Semua Pelayanan' }}</td></tr>
    </table>

    <h2>REKAPITULASI</h2>
    @if($data->count())
        <table>
            <thead><tr><th class="no">No</th><th>Jenis Pelayanan</th><th class="number">Jumlah</th></tr></thead>
            <tbody>
                @foreach($data as $index => $item)
                    <tr><td class="no">{{ $index + 1 }}</td><td>{{ $item->jenisPelayanan?->nama_pelayanan ?? '-' }}</td><td class="number">{{ number_format($item->total, 0, ',', '.') }}</td></tr>
                @endforeach
            </tbody>
            <tfoot><tr><td></td><td>TOTAL</td><td class="number">{{ number_format($data->sum('total'), 0, ',', '.') }}</td></tr></tfoot>
        </table>
    @else
        <div class="empty">Tidak ditemukan data berdasarkan filter yang dipilih.</div>
    @endif

    <h2>RINGKASAN</h2>
    <table class="summary">
        <tr><td class="label">Jumlah Jenis Pelayanan</td><td>{{ $data->count() }}</td></tr>
        <tr><td class="label">Total Rekapitulasi</td><td>{{ number_format($data->sum('total'), 0, ',', '.') }}</td></tr>
    </table>

    <h2>KETERANGAN</h2>
    <div class="notes">
        <p>Laporan ini merupakan hasil rekapitulasi pelaksanaan pelayanan administrasi kependudukan berdasarkan Berita Acara yang telah dilaksanakan selama periode pelaporan. Rekapitulasi disusun berdasarkan data pelayanan yang telah dicatat dan dihimpun, sehingga dapat memberikan gambaran mengenai jumlah pelayanan administrasi kependudukan yang telah dilaksanakan pada periode yang bersangkutan.</p>
        <p>Laporan ini dibuat sebagai bahan dokumentasi dan informasi pelaksanaan pelayanan administrasi kependudukan serta dapat digunakan sebagai bahan monitoring, evaluasi, dan pendukung dalam pelaksanaan tugas dan fungsi pelayanan pada Dinas Kependudukan dan Pencatatan Sipil Kabupaten Magetan.</p>
        <p>Demikian laporan rekapitulasi ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="signature">
        <div>Magetan, {{ $printedAt->translatedFormat('d F Y') }}</div>
        <div>Dicetak oleh,</div>
        <div class="space"></div>
        <div>{{ $petugas }}</div>
        <div>NIP. .................................</div>
    </div>

    <div class="footer">Sistem Rekap Berita Acara — Dinas Kependudukan dan Pencatatan Sipil Kabupaten Magetan <span class="page">Halaman 1</span></div>

    @if($isPrint ?? false)
        <script>
            window.addEventListener('load', function () {
                window.print();
            });
        </script>
    @endif
</body>
</html>
