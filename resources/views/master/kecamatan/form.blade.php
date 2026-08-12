<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kecamatan</title>
</head>
<body>
@include('layouts.sidebar')
<main class="sipper-content">
    <h2>{{ isset($kecamatan) ? 'Edit Kecamatan' : 'Tambah Kecamatan' }}</h2>
    <form method="POST" action="{{ isset($kecamatan) ? route('kecamatan.update', $kecamatan) : route('kecamatan.store') }}">
        @csrf
        @if(isset($kecamatan)) @method('PUT') @endif

        <div>
            <label>Pilih kecamatan yang sudah ada</label>
            <select name="kecamatan_existing">
                <option value="">-- Pilih / tulis manual --</option>
                @foreach(App\Models\Kecamatan::orderBy('nama_kecamatan')->get() as $item)
                    <option value="{{ $item->nama_kecamatan }}">{{ $item->nama_kecamatan }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Atau tulis nama kecamatan baru</label>
            <input type="text" name="nama_kecamatan" value="{{ old('nama_kecamatan', $kecamatan->nama_kecamatan ?? '') }}" placeholder="Ketik nama kecamatan jika tidak ada di daftar">
        </div>

</main>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
