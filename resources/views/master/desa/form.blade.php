@include('layouts.sidebar')

<main class="sipper-content">
    <div style="padding:24px;max-width:720px">
        <h2>{{ isset($desa) ? 'Edit Desa' : 'Tambah Desa' }}</h2>

        @if($errors->any())
            <div style="background:#fff1f2;color:#7f1d1d;padding:10px;border-radius:8px;margin-bottom:12px">
                <ul style="margin:0;padding-left:16px">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ isset($desa) ? route('desa.update', $desa) : route('desa.store') }}">
            @csrf
            @if(isset($desa)) @method('PUT') @endif

            <div style="margin-bottom:12px">
                <label style="display:block;margin-bottom:6px">Pilih kecamatan yang sudah ada</label>
                <select name="kecamatan_id" style="width:100%;padding:8px;border-radius:6px;border:1px solid #e6eef8">
                    <option value="">-- Pilih / tulis manual --</option>
                    @foreach($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $desa->kecamatan_id ?? '') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom:12px">
                <label style="display:block;margin-bottom:6px">Atau tulis nama kecamatan baru</label>
                <input type="text" name="kecamatan_manual" value="{{ old('kecamatan_manual') }}" placeholder="Isi jika ingin membuat kecamatan baru" style="width:100%;padding:8px;border-radius:6px;border:1px solid #e6eef8">
            </div>

            <div style="margin-bottom:12px">
                <label style="display:block;margin-bottom:6px">Nama Desa</label>
                <input type="text" name="nama_desa" value="{{ old('nama_desa', $desa->nama_desa ?? '') }}" required style="width:100%;padding:8px;border-radius:6px;border:1px solid #e6eef8">
            </div>

            <div style="display:flex;gap:8px">
                <button type="submit" style="padding:8px 12px;border-radius:8px;background:#2563eb;color:#fff;border:none">Simpan</button>
                <a href="{{ route('desa.index') }}" style="padding:8px 12px;border-radius:8px;background:#f3f4f6;color:#374151;text-decoration:none">Batal</a>
            </div>
        </form>
    </div>
</main>
