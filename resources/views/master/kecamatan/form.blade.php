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
    .wilayah-field input, .wilayah-field select { width: 100%; height: 36px; border: 1px solid #cbd5e1; border-radius: 2px; appearance: none; background-color: #fff; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23334155'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m6 9 6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; background-size: 14px 14px; padding: 0 34px 0 10px; color: #334155; font-size: 12px; }
    .wilayah-field input:focus, .wilayah-field select:focus { border-color: var(--sip-primary); outline: 0; box-shadow: 0 0 0 2px rgba(29, 97, 232, .12); }
    .wilayah-field-wide { grid-column: 1 / -1; }
    .wilayah-form-actions { display: flex; justify-content: flex-end; gap: 8px; padding: 0 16px 16px; }
    .wilayah-save { min-height: 35px; padding: 0 16px; border: 1px solid var(--sip-primary); border-radius: 3px; background: var(--sip-primary); color: #fff; font-size: 12px; font-weight: 700; cursor: pointer; }
    .wilayah-save:hover { background: var(--sip-primary-hover); }
    @media (max-width: 640px) { .wilayah-form-page { padding: 12px; } .wilayah-form-panel { width: 100%; } .wilayah-form-header { align-items: flex-start; flex-direction: column; padding: 16px; } .wilayah-form-title { font-size: 19px; } .wilayah-form-content { padding: 16px; } .wilayah-fields { grid-template-columns: 1fr; padding: 14px; } .wilayah-field-wide { grid-column: auto; } .wilayah-form-actions { align-items: stretch; flex-direction: column-reverse; padding: 0 14px 14px; } .wilayah-save, .wilayah-cancel { width: 100%; } }

    .service-picker { position: relative; width: 100%; }
    .service-picker-toggle {
        width: 100%;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        border: 1px solid #cbd5e1;
        border-radius: 2px;
        background: #fff;
        color: #334155;
        padding: 0 10px;
        font-size: 12px;
        line-height: 1;
        text-align: left;
        cursor: pointer;
        box-sizing: border-box;
    }
    .service-picker-toggle:focus,
    .service-picker.is-open .service-picker-toggle {
        border-color: var(--sip-primary);
        outline: none;
        box-shadow: 0 0 0 2px rgba(29, 97, 232, .12);
    }
    .service-picker-chevron {
        flex: 0 0 auto;
        width: 7px;
        height: 7px;
        border-right: 1.5px solid #334155;
        border-bottom: 1.5px solid #334155;
        font-size: 0;
        transform: rotate(45deg) translate(-2px, -2px);
        transition: transform .15s;
    }
    .service-picker.is-open .service-picker-chevron { transform: rotate(225deg) translate(-2px, -2px); }
    .service-picker-menu {
        position: absolute;
        z-index: 30;
        top: calc(100% + 4px);
        left: 0;
        width: 100%;
        max-width: 100%;
        max-height: 250px;
        display: block;
        overflow-y: auto;
        padding: 6px;
        border: 1px solid #cbd5e1;
        border-radius: 2px;
        background: #fff;
        box-shadow: 0 10px 20px rgba(15, 23, 42, .16);
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transform: translateY(-8px) scaleY(.96);
        transform-origin: top center;
        transition: opacity .18s ease, transform .18s ease, visibility 0s linear .18s;
    }
    .service-picker.is-open .service-picker-menu {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        transform: translateY(0) scaleY(1);
        transition-delay: 0s;
    }
    .service-picker-option {
        width: 100%;
        min-height: 30px;
        border: 1px solid transparent;
        border-radius: 2px;
        background: transparent;
        color: #334155;
        padding: 5px 8px;
        font-size: 12px;
        line-height: 1.25;
        white-space: normal;
        overflow-wrap: anywhere;
        text-align: left;
        cursor: pointer;
    }
    .service-picker-option:hover,
    .service-picker-option.is-selected {
        border-color: var(--sip-primary);
        background: rgba(29, 97, 232, .08);
        color: var(--sip-primary);
        font-weight: 700;
    }
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
                                @php
                                    $selectedKecEx = old('kecamatan_existing', '');
                                @endphp
                                <div class="service-picker" data-form-kecex-picker>
                                    <input type="hidden" name="kecamatan_existing" value="{{ $selectedKecEx }}">
                                    <button type="button" class="service-picker-toggle" data-form-kecex-toggle aria-haspopup="listbox" aria-expanded="false">
                                        <span data-form-kecex-label>{{ $selectedKecEx ?: '-- Pilih atau Tulis Manual --' }}</span>
                                        <span class="service-picker-chevron" aria-hidden="true">&#9662;</span>
                                    </button>
                                    <div class="service-picker-menu" role="listbox" aria-label="Pilih Kecamatan">
                                        <button type="button" class="service-picker-option {{ $selectedKecEx == '' ? 'is-selected' : '' }}" data-form-kecex-option="" role="option" aria-selected="{{ $selectedKecEx == '' ? 'true' : 'false' }}">-- Pilih atau Tulis Manual --</button>
                                        @foreach(App\Models\Kecamatan::orderBy('nama_kecamatan')->get() as $item)
                                            <button type="button" class="service-picker-option {{ $selectedKecEx == $item->nama_kecamatan ? 'is-selected' : '' }}" data-form-kecex-option="{{ $item->nama_kecamatan }}" role="option" aria-selected="{{ $selectedKecEx == $item->nama_kecamatan ? 'true' : 'false' }}">{{ $item->nama_kecamatan }}</button>
                                        @endforeach
                                    </div>
                                </div>
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
<script>
    const formKecExPicker = document.querySelector('[data-form-kecex-picker]');
    if (formKecExPicker) {
        const toggle = formKecExPicker.querySelector('[data-form-kecex-toggle]');
        const input = formKecExPicker.querySelector('input[name="kecamatan_existing"]');
        const label = formKecExPicker.querySelector('[data-form-kecex-label]');
        const options = [...formKecExPicker.querySelectorAll('[data-form-kecex-option]')];

        toggle.addEventListener('click', () => {
            const isOpen = formKecExPicker.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        options.forEach(opt => {
            opt.addEventListener('click', () => {
                input.value = opt.dataset.formKecexOption;
                label.textContent = opt.textContent;
                options.forEach(o => {
                    o.classList.toggle('is-selected', o === opt);
                    o.setAttribute('aria-selected', o === opt ? 'true' : 'false');
                });
                formKecExPicker.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
            });
        });

        document.addEventListener('click', (e) => {
            if (!formKecExPicker.contains(e.target)) {
                formKecExPicker.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });
    }
</script>
