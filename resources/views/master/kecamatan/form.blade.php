@vite(['resources/css/app.css', 'resources/js/app.js'])
@include('layouts.sidebar')

<style>
    .wilayah-form-page { min-height: 100vh; padding: 18px clamp(16px, 3vw, 32px) 32px; background: var(--sip-bg); }
    .wilayah-form-panel { max-width: 920px; margin: 0 auto; overflow: hidden; border: 1px solid #dbe3ed; border-radius: 3px; background: #fff; box-shadow: 0 1px 3px rgba(15, 23, 42, .04); }
    .wilayah-form-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 18px 20px; border-bottom: 1px solid #dbe3ed; }
    .wilayah-kicker { margin: 0 0 4px; color: var(--sip-primary); font-size: 10px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
    .wilayah-form-title { margin: 0; color: #0f172a; font-size: 22px; line-height: 1.2; }
    .wilayah-form-subtitle { margin: 5px 0 0; color: #64748b; font-size: 12px; }
    .wilayah-back, .wilayah-cancel { display: inline-flex; align-items: center; justify-content: center; min-height: 35px; padding: 0 14px; border: 1px solid #cbd5e1; border-radius: 3px; background: #fff; color: #334155; font-size: 12px; font-weight: 700; text-decoration: none; }
    .wilayah-back:hover, .wilayah-cancel:hover { background: #f8fafc; }
    .wilayah-error { margin: 14px 20px 0; padding: 10px 12px; border: 1px solid #fecaca; border-radius: 3px; background: #fff1f2; color: #b91c1c; font-size: 12px; }
    .wilayah-error p { margin: 0 0 4px; font-weight: 700; }
    .wilayah-error ul { margin: 0; padding-left: 18px; }
    .wilayah-form-content { padding: 18px 20px 20px; }
    .wilayah-form-section { overflow: hidden; border: 1px solid #dbe3ed; border-radius: 3px; }
    .wilayah-section-title { padding: 10px 12px; background: var(--sip-sidebar-bg); color: #fff; font-size: 13px; font-weight: 700; }
    .wilayah-fields { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px 20px; padding: 16px; }
    .wilayah-field label { display: block; margin-bottom: 5px; color: #334155; font-size: 11px; font-weight: 700; }
    .wilayah-field input, .wilayah-field select { width: 100%; height: 36px; border: 1px solid #cbd5e1; border-radius: 2px; background: #fff; padding: 0 10px; color: #334155; font-size: 12px; }
    .wilayah-field input:focus, .wilayah-field select:focus { border-color: var(--sip-primary); outline: 0; box-shadow: 0 0 0 2px rgba(29, 97, 232, .12); }
    .wilayah-field-wide { grid-column: 1 / -1; }
    .wilayah-form-actions { display: flex; justify-content: flex-end; gap: 8px; padding: 0 16px 16px; }
    .wilayah-save { min-height: 35px; padding: 0 16px; border: 1px solid var(--sip-primary); border-radius: 3px; background: var(--sip-primary); color: #fff; font-size: 12px; font-weight: 700; cursor: pointer; }
    .wilayah-save:hover { background: var(--sip-primary-hover); }
    @media (max-width: 640px) { .wilayah-form-page { padding: 12px; } .wilayah-form-panel { width: 100%; } .wilayah-form-header { align-items: flex-start; flex-direction: column; padding: 16px; } .wilayah-form-title { font-size: 19px; } .wilayah-form-content { padding: 16px; } .wilayah-fields { grid-template-columns: 1fr; padding: 14px; } .wilayah-field-wide { grid-column: auto; } .wilayah-form-actions { align-items: stretch; flex-direction: column-reverse; padding: 0 14px 14px; } .wilayah-save, .wilayah-cancel { width: 100%; } }
</style>

<main class="sipper-content">
    @include('layouts.header', ['pageTitle' => isset($kecamatan) ? 'Edit Kecamatan' : 'Tambah Kecamatan'])
    <div class="wilayah-form-page">
        <div class="wilayah-form-panel">

            {{-- HEADER --}}
            <div class="wilayah-form-header">
                    <div>
                        <p class="wilayah-kicker">
                            ADMINISTRASI
                        </p>
                        <h1 class="wilayah-form-title">
                            {{ isset($kecamatan) ? 'Edit Kecamatan' : 'Tambah Kecamatan' }}
                        </h1>
                        <p class="wilayah-form-subtitle">
                            {{ isset($kecamatan) ? 'Perbarui data kecamatan yang sudah ada' : 'Tambahkan kecamatan baru ke sistem' }}
                        </p>
                    </div>
            </div>

            {{-- ERROR --}}
            @if($errors->any())
                <div class="wilayah-error">
                    <p>Terjadi kesalahan:</p>
                    <ul>
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM --}}
            <div class="wilayah-form-content">
                <form method="POST" action="{{ isset($kecamatan) ? route('kecamatan.update', $kecamatan) : route('kecamatan.store') }}">
                    @csrf
                    @if(isset($kecamatan)) @method('PUT') @endif

                    <section class="wilayah-form-section">
                        <div class="wilayah-section-title">
                                {{ isset($kecamatan) ? 'Data Kecamatan' : 'Data Kecamatan Baru' }}
                            </h2>
                        </div>

                        <div class="wilayah-fields">
                            {{-- Pilih Kecamatan Existing --}}
                            <div class="wilayah-field">
                                <label>
                                    Pilih Kecamatan yang Sudah Ada
                                </label>
                                <select name="kecamatan_existing">
                                    <option value="">-- Pilih atau Tulis Manual --</option>
                                    @foreach(App\Models\Kecamatan::orderBy('nama_kecamatan')->get() as $item)
                                        <option value="{{ $item->nama_kecamatan }}" {{ old('kecamatan_existing') == $item->nama_kecamatan ? 'selected' : '' }}>{{ $item->nama_kecamatan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Nama Kecamatan --}}
                            <div class="wilayah-field">
                                <label>
                                    Nama Kecamatan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_kecamatan" value="{{ old('nama_kecamatan', $kecamatan->nama_kecamatan ?? '') }}" placeholder="Ketik nama kecamatan" required>
                            </div>
                        </div>

                        {{-- TOMBOL --}}
                        <div class="wilayah-form-actions">
                            <button type="submit" class="wilayah-save">
                                {{ isset($kecamatan) ? 'Perbarui' : 'Tambah' }} Kecamatan
                            </button>
                            <a href="{{ route('kecamatan.index') }}" class="wilayah-cancel">
                                Batal
                            </a>
                        </div>
                    </section>
                </form>
            </div>

        </div>
    </div>
</main>
