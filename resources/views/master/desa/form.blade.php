<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Desa</title>
</head>
<body>
@include('layouts.sidebar')
<main class="sipper-content">
    <h2>{{ isset($desa) ? 'Edit Desa' : 'Tambah Desa' }}</h2>
    <form method="POST" action="{{ isset($desa) ? route('desa.update', $desa) : route('desa.store') }}">
        @csrf
        @if(isset($desa)) @method('PUT') @endif
        <div>
            <label>Pilih kecamatan yang sudah ada</label>
            <select name="kecamatan_id">
                <option value="">-- Pilih / tulis manual --</option>
                @foreach($kecamatans as $kecamatan)
                    <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $desa->kecamatan_id ?? '') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Atau tulis nama kecamatan baru</label>
            <input type="text" name="kecamatan_manual" value="{{ old('kecamatan_manual') }}" placeholder="Isi jika ingin membuat kecamatan baru">
        </div>
        <div>
            <label>Nama Desa</label>
            <input type="text" name="nama_desa" value="{{ old('nama_desa', $desa->nama_desa ?? '') }}" required>
        </div>
</main>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
