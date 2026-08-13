@include('layouts.sidebar')

<main class="sipper-content">
    <div style="padding:24px;max-width:720px">
        <h2>{{ isset($jenisPelayanan) ? 'Edit Jenis Pelayanan' : 'Tambah Jenis Pelayanan' }}</h2>

        @if($errors->any())
            <div style="background:#fff1f2;color:#7f1d1d;padding:10px;border-radius:8px;margin-bottom:12px">
                <ul style="margin:0;padding-left:16px">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ isset($jenisPelayanan) ? route('jenis-pelayanan.update', $jenisPelayanan) : route('jenis-pelayanan.store') }}">
            @csrf
            @if(isset($jenisPelayanan)) @method('PUT') @endif

            <div style="margin-bottom:12px">
                <label style="display:block;margin-bottom:6px">Nama Pelayanan</label>
                <input type="text" name="nama_pelayanan" value="{{ old('nama_pelayanan', $jenisPelayanan->nama_pelayanan ?? '') }}" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #e6eef8">
            </div>

            <div style="margin-bottom:12px">
                <label style="display:block;margin-bottom:6px">Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori', $jenisPelayanan->kategori ?? '') }}" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #e6eef8">
            </div>

            <div style="display:flex;gap:8px">
                <button type="submit" style="padding:8px 12px;border-radius:8px;background:#2563eb;color:#fff;border:none">Simpan</button>
                <a href="{{ route('jenis-pelayanan.index') }}" style="padding:8px 12px;border-radius:8px;background:#f3f4f6;color:#374151;text-decoration:none">Batal</a>
            </div>
        </form>
    </div>
</main>
