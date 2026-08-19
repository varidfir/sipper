@vite(['resources/css/app.css', 'resources/js/app.js'])
@include('layouts.sidebar')

<style>
    .jenis-form-page { min-height: 100vh; padding: 18px clamp(16px, 3vw, 32px) 32px; background: #f4f6f9; }
    .jenis-form-panel { max-width: 920px; margin: 0 auto; overflow: hidden; border: 1px solid #dbe3ed; border-radius: 3px; background: #fff; box-shadow: 0 1px 3px rgba(15, 23, 42, .04); }
    .jenis-form-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 18px 20px; border-bottom: 1px solid #dbe3ed; }
    .jenis-form-kicker { margin: 0 0 4px; color: #1d61e8; font-size: 10px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
    .jenis-form-title { margin: 0; color: #0f172a; font-size: 22px; line-height: 1.2; }
    .jenis-form-subtitle { margin: 5px 0 0; color: #64748b; font-size: 12px; }
    .jenis-form-back, .jenis-form-cancel { display: inline-flex; align-items: center; justify-content: center; min-height: 35px; padding: 0 14px; border: 1px solid #cbd5e1; border-radius: 3px; background: #fff; color: #334155; font-size: 12px; font-weight: 700; text-decoration: none; }
    .jenis-form-back:hover, .jenis-form-cancel:hover { background: #f8fafc; }
    .jenis-form-error { margin: 14px 20px 0; padding: 10px 12px; border: 1px solid #fecaca; border-radius: 3px; background: #fff1f2; color: #b91c1c; font-size: 12px; }
    .jenis-form-error p { margin: 0 0 4px; font-weight: 700; }
    .jenis-form-error ul { margin: 0; padding-left: 18px; }
    .jenis-form-content { padding: 18px 20px 20px; }
    .jenis-form-section { overflow: hidden; border: 1px solid #dbe3ed; border-radius: 3px; }
    .jenis-section-title { padding: 10px 12px; background: #1d61e8; color: #fff; font-size: 13px; font-weight: 700; }
    .jenis-fields { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px 20px; padding: 16px; }
    .jenis-field label { display: block; margin-bottom: 5px; color: #334155; font-size: 11px; font-weight: 700; }
    .jenis-field input { width: 100%; height: 36px; border: 1px solid #cbd5e1; border-radius: 2px; background: #fff; padding: 0 10px; color: #334155; font-size: 12px; }
    .jenis-field input:focus { border-color: #60a5fa; outline: 0; box-shadow: 0 0 0 2px rgba(59, 130, 246, .12); }
    .jenis-form-actions { display: flex; justify-content: flex-end; gap: 8px; padding: 0 16px 16px; }
    .jenis-save { min-height: 35px; padding: 0 16px; border: 1px solid #1d61e8; border-radius: 3px; background: #1d61e8; color: #fff; font-size: 12px; font-weight: 700; cursor: pointer; }
    .jenis-save:hover { background: #1752ca; }
    @media (max-width: 640px) { .jenis-form-page { padding: 12px; } .jenis-form-panel { width: 100%; } .jenis-form-header { align-items: flex-start; flex-direction: column; padding: 16px; } .jenis-form-title { font-size: 19px; } .jenis-form-back { width: 100%; } .jenis-form-content { padding: 16px; } .jenis-fields { grid-template-columns: 1fr; padding: 14px; } .jenis-form-actions { align-items: stretch; flex-direction: column-reverse; padding: 0 14px 14px; } .jenis-save, .jenis-form-cancel { width: 100%; } }
</style>

<main class="sipper-content">
    @include('layouts.header', ['pageTitle' => isset($jenisPelayanan) ? 'Edit Jenis Pelayanan' : 'Tambah Jenis Pelayanan'])
    <div class="jenis-form-page">
        <div class="jenis-form-panel">

            {{-- HEADER --}}
            <div class="jenis-form-header">
                    <div>
                        <p class="jenis-form-kicker">
                            ADMINISTRASI
                        </p>
                        <h1 class="jenis-form-title">
                            {{ isset($jenisPelayanan) ? 'Edit Jenis Pelayanan' : 'Tambah Jenis Pelayanan' }}
                        </h1>
                        <p class="jenis-form-subtitle">
                            {{ isset($jenisPelayanan) ? 'Perbarui jenis pelayanan yang sudah ada' : 'Tambahkan jenis pelayanan baru ke sistem' }}
                        </p>
                    </div>
                    <a href="{{ route('jenis-pelayanan.index') }}" class="jenis-form-back">
                        ← Kembali
                    </a>
            </div>

            {{-- ERROR --}}
            @if($errors->any())
                <div class="jenis-form-error">
                    <p>Terjadi kesalahan:</p>
                    <ul>
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM --}}
            <div class="jenis-form-content">
                <form method="POST" action="{{ isset($jenisPelayanan) ? route('jenis-pelayanan.update', $jenisPelayanan) : route('jenis-pelayanan.store') }}">
                    @csrf
                    @if(isset($jenisPelayanan)) @method('PUT') @endif

                    <section class="jenis-form-section">
                        <div class="jenis-section-title">
                                {{ isset($jenisPelayanan) ? 'Data Jenis Pelayanan' : 'Data Jenis Pelayanan Baru' }}
                            </h2>
                        </div>

                        <div class="jenis-fields">
                            {{-- Nama Pelayanan --}}
                            <div class="jenis-field">
                                <label>
                                    Nama Pelayanan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_pelayanan" value="{{ old('nama_pelayanan', $jenisPelayanan->nama_pelayanan ?? '') }}" placeholder="Contoh: Penerbitan Surat Keterangan" required>
                            </div>

                            {{-- Kategori --}}
                            <div class="jenis-field">
                                <label>
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="kategori" value="{{ old('kategori', $jenisPelayanan->kategori ?? '') }}" placeholder="Contoh: Administrasi, Sosial, dll" required>
                            </div>
                        </div>

                        {{-- TOMBOL --}}
                        <div class="jenis-form-actions">
                            <button type="submit" class="jenis-save">
                                {{ isset($jenisPelayanan) ? 'Perbarui' : 'Tambah' }} Jenis Pelayanan
                            </button>
                            <a href="{{ route('jenis-pelayanan.index') }}" class="jenis-form-cancel">
                                Batal
                            </a>
                        </div>
                    </section>
                </form>
            </div>

        </div>
    </div>
</main>
