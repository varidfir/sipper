@include('layouts.sidebar')

<main class="sipper-content">
    <div style="padding:24px">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:12px">
            <h2 style="margin:0">Data Jenis Pelayanan</h2>
            <a href="{{ route('jenis-pelayanan.create') }}" style="padding:8px 12px;border-radius:8px;background:#2563eb;color:#fff;text-decoration:none">Tambah Jenis Pelayanan</a>
        </div>

        @if(session('status'))
            <div style="padding:10px;border-radius:8px;background:#ecfdf5;color:#065f46;margin-bottom:12px">{{ session('status') }}</div>
        @endif

        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="text-align:left;border-bottom:1px solid #e6eef8">
                    <th style="padding:8px">#</th>
                    <th style="padding:8px">Nama Pelayanan</th>
                    <th style="padding:8px">Kategori</th>
                    <th style="padding:8px;width:200px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jenisPelayanans as $jenisPelayanan)
                    <tr>
                        <td style="padding:8px">{{ $loop->iteration }}</td>
                        <td style="padding:8px">{{ $jenisPelayanan->nama_pelayanan }}</td>
                        <td style="padding:8px">{{ $jenisPelayanan->kategori }}</td>
                        <td style="padding:8px">
                            <a href="{{ route('jenis-pelayanan.edit', $jenisPelayanan) }}" style="margin-right:8px;color:#2563eb">Edit</a>
                            <form method="POST" action="{{ route('jenis-pelayanan.destroy', $jenisPelayanan) }}" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:transparent;border:none;color:#dc2626;cursor:pointer">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
