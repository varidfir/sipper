<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Jenis Pelayanan</title>
</head>
<body>
@include('layouts.sidebar')
<main class="sipper-content">
    <h2>Data Jenis Pelayanan</h2>
    <a href="{{ route('jenis-pelayanan.create') }}">Tambah Jenis Pelayanan</a>
    @if(session('status'))<p>{{ session('status') }}</p>@endif
    <ul>
        @foreach($jenisPelayanans as $jenisPelayanan)
            <li>{{ $jenisPelayanan->nama_pelayanan }} ({{ $jenisPelayanan->kategori }})
                <a href="{{ route('jenis-pelayanan.edit', $jenisPelayanan) }}">Edit</a>
                <form method="POST" action="{{ route('jenis-pelayanan.destroy', $jenisPelayanan) }}" style="display:inline">
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
