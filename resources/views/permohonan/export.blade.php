<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Permohonan</title>
</head>
<body>
@include('layouts.sidebar')
<main class="sipper-content">
    <h2>Export Permohonan</h2>
    <table border="1" cellpadding="4" cellspacing="0">
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Kecamatan</th>
                <th>Desa</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permohonans as $permohonan)
                <tr>
                    <td>{{ $permohonan->nomor_permohonan }}</td>
                    <td>{{ $permohonan->nama_pemohon }}</td>
                    <td>{{ $permohonan->tanggal_permohonan?->format('Y-m-d') }}</td>
                    <td>{{ $permohonan->jenisPelayanan->nama_pelayanan ?? '-' }}</td>
                    <td>{{ $permohonan->kecamatan->nama_kecamatan ?? '-' }}</td>
                    <td>{{ $permohonan->desa->nama_desa ?? '-' }}</td>
                    <td>{{ $permohonan->keterangan }}</td>
                </</main>
tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
