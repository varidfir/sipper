<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Jenis Pelayanan</title>
</head>
<body>
@include('layouts.sidebar')
<main class="sipper-content">
    <h2>{{ isset($jenisPelayanan) ? 'Edit Jenis Pelayanan' : 'Tambah Jenis Pelayanan' }}</h2>
    <form method="POST" action="{{ isset($jenisPelayanan) ? route('jenis-pelayanan.update', $jenisPelayanan) : route('jenis-pelayanan.store') }}">
        @csrf
        @if(isset($jenisPelayanan)) @method('PUT') @endif
        <div>
            <label>Nama Pelayanan</label>
            <input type="text" name="nama_pelayanan" value="{{ old('nama_pelayanan', $jenisPelayanan->nama_pelayanan ?? '') }}" required>
        </div>
        <div>
            <label>Kategori</label>
            <input type="text" name="kategori" value="{{ old('kategori', $jenisPelayanan->kategori ?? '') }}" required>
        </div>
</main>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
