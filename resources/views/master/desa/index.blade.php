<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Desa</title>
</head>
<body>
@include('layouts.sidebar')
<main class="sipper-content">
    <h2>Data Desa</h2>
    <a href="{{ route('desa.create') }}">Tambah Desa</a>
    @if(session('status'))<p>{{ session('status') }}</p>@endif
    <ul>
        @foreach($desas as $desa)
            <li>{{ $desa->nama_desa }} ({{ $desa->kecamatan->nama_kecamatan ?? '-' }})
                <a href="{{ route('desa.edit', $desa) }}">Edit</a>
                <form method="POST" action="{{ route('desa.destroy', $desa) }}" style="display:inline">
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
