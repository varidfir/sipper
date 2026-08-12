<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kecamatan</title>
</head>
<body>
@include('layouts.sidebar')
<main class="sipper-content">
    <h2>Data Kecamatan</h2>
    <a href="{{ route('kecamatan.create') }}">Tambah Kecamatan</a>
    @if(session('status'))<p>{{ session('status') }}</p>@endif
    <ul>
        @foreach($kecamatans as $kecamatan)
            <li>{{ $kecamatan->nama_kecamatan }}
                <a href="{{ route('kecamatan.edit', $kecamatan) }}">Edit</a>
                <form method="POST" action="{{ route('kecamatan.destroy', $kecamatan) }}" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
              </main>
  </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
