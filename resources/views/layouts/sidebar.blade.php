@php
    $sidebarUser = auth()->user();
    $sidebarIsAdmin = strtolower($sidebarUser?->role ?? '') === 'admin';
@endphp

<aside class="sipper-sidebar" aria-label="Navigasi utama">

    {{-- =====================================================
        BRAND
    ====================================================== --}}
    <a href="{{ route('dashboard') }}" class="sipper-brand">

        <div class="sipper-brand-logo">
            <img
                src="{{ asset('images/logo-magetan.svg') }}"
                alt="Logo Kabupaten Magetan"
            />
        </div>

        <div class="sipper-brand-text">
            <span class="sipper-brand-name">
                Dispendukcapil
            </span>

            <span class="sipper-brand-sub">
                Kabupaten Magetan
            </span>
        </div>

    </a>


    {{-- =====================================================
        AREA MENU
        HANYA BAGIAN INI YANG SCROLL
    ====================================================== --}}
    <div class="sipper-sidebar-menu">


        {{-- =================================================
            MENU UTAMA
        ================================================== --}}
        <div class="sipper-nav-section">

            <div class="sipper-nav-title">
                Menu Utama
            </div>


            <nav class="sipper-nav">

                {{-- Dashboard --}}
                <a
                    href="{{ route('dashboard') }}"
                    class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
                >

                    <span class="sipper-nav-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                        >
                            <path
                                d="M3 9.5L12 3L21 9.5V20C21 20.55 20.55 21 20 21H4C3.45 21 3 20.55 3 20V9.5Z"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M9 21V12H15V21"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                    </span>

                    <span class="sipper-nav-label">
                        Dashboard
                    </span>

                </a>


                {{-- Data Permohonan --}}
                <a
                    href="{{ route('permohonan.index') }}"
                    class="{{ request()->routeIs('permohonan.index', 'permohonan.show', 'permohonan.edit') ? 'active' : '' }}"
                >

                    <span class="sipper-nav-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                        >
                            <path
                                d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M14 2V8H20"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M16 13H8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M16 17H8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M10 9H8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                    </span>

                    <span class="sipper-nav-label">
                        Data Permohonan
                    </span>

                </a>


                {{-- Input Rekap --}}
                <a
                    href="{{ route('permohonan.create') }}"
                    class="{{ request()->routeIs('permohonan.create') ? 'active' : '' }}"
                >

                    <span class="sipper-nav-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                        >
                            <path
                                d="M11 4H4C3.44772 4 3 4.44772 3 5V19C3 19.5523 3.44772 20 4 20H18C18.5523 20 19 19.5523 19 19V12"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M18.5 2.5C19.3284 1.67157 20.6716 1.67157 21.5 2.5C22.3284 3.32843 22.3284 4.67157 21.5 5.5L12 15L8 16L9 12L18.5 2.5Z"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                    </span>

                    <span class="sipper-nav-label">
                        Input Rekap
                    </span>

                </a>


                {{-- Rekapitulasi --}}
                <a
                    href="{{ route('permohonan.recap') }}"
                    class="{{ request()->routeIs('permohonan.recap') ? 'active' : '' }}"
                >

                    <span class="sipper-nav-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                        >
                            <rect
                                x="3"
                                y="4"
                                width="18"
                                height="16"
                                rx="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <line
                                x1="7"
                                y1="9"
                                x2="17"
                                y2="9"
                                stroke-linecap="round"
                            />

                            <line
                                x1="7"
                                y1="13"
                                x2="17"
                                y2="13"
                                stroke-linecap="round"
                            />

                            <line
                                x1="7"
                                y1="17"
                                x2="13"
                                y2="17"
                                stroke-linecap="round"
                            />
                        </svg>

                    </span>

                    <span class="sipper-nav-label">
                        Rekapitulasi
                    </span>

                </a>


                {{-- Export Data --}}
                <a
                    href="{{ route('permohonan.export') }}"
                    class="{{ request()->routeIs('permohonan.export') ? 'active' : '' }}"
                >

                    <span class="sipper-nav-icon">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                        >
                            <path
                                d="M21 15V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142 3 19.5304 3 19V15"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M7 10L12 15L17 10"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M12 15V3"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                    </span>

                    <span class="sipper-nav-label">
                        Export Data
                    </span>

                </a>

            </nav>

        </div>


        {{-- =================================================
            MASTER DATA
        ================================================== --}}
        @if($sidebarIsAdmin)

            <div class="sipper-nav-section">

                <div class="sipper-nav-title">
                    Master Data
                </div>


                <nav class="sipper-nav">

                    {{-- Kecamatan --}}
                    <a
                        href="{{ route('kecamatan.index') }}"
                        class="{{ request()->routeIs('kecamatan.*') ? 'active' : '' }}"
                    >

                        <span class="sipper-nav-icon">

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                            >
                                <path
                                    d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />

                                <circle
                                    cx="12"
                                    cy="10"
                                    r="3"
                                />
                            </svg>

                        </span>

                        <span class="sipper-nav-label">
                            Wilayah Kecamatan
                        </span>

                    </a>


                    {{-- Desa --}}
                    <a
                        href="{{ route('desa.index') }}"
                        class="{{ request()->routeIs('desa.*') ? 'active' : '' }}"
                    >

                        <span class="sipper-nav-icon">

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                            >
                                <path
                                    d="M3 9L12 2L21 9V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V9Z"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />

                                <path
                                    d="M9 21V12H15V21"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>

                        </span>

                        <span class="sipper-nav-label">
                            Wilayah Desa
                        </span>

                    </a>


                    {{-- Jenis Pelayanan --}}
                    <a
                        href="{{ route('jenis-pelayanan.index') }}"
                        class="{{ request()->routeIs('jenis-pelayanan.*') ? 'active' : '' }}"
                    >

                        <span class="sipper-nav-icon">

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                            >
                                <rect
                                    x="3"
                                    y="4"
                                    width="18"
                                    height="16"
                                    rx="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />

                                <path
                                    d="M7 8H17"
                                    stroke-linecap="round"
                                />

                                <path
                                    d="M7 12H17"
                                    stroke-linecap="round"
                                />

                                <path
                                    d="M7 16H13"
                                    stroke-linecap="round"
                                />
                            </svg>

                        </span>

                        <span class="sipper-nav-label">
                            Jenis Pelayanan
                        </span>

                    </a>

                </nav>

            </div>


            {{-- =================================================
                PENGATURAN
            ================================================== --}}
            <div class="sipper-nav-section">

                <div class="sipper-nav-title">
                    Pengaturan
                </div>


                <nav class="sipper-nav">

                    <a
                        href="{{ route('profile.show') }}"
                        class="{{ request()->routeIs('profile.*') ? 'active' : '' }}"
                    >

                        <span class="sipper-nav-icon">

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                            >
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="3"
                                />

                                <path
                                    d="M19.4 15A1.65 1.65 0 0 0 19.7 16.9L19.8 17.1L17.1 19.8L16.9 19.7A1.65 1.65 0 0 0 15 19.4C14.3 19.8 13.9 20.5 13.9 21.3V21.5H10.1V21.3C10.1 20.5 9.7 19.8 9 19.4A1.65 1.65 0 0 0 7.1 19.7L6.9 19.8L4.2 17.1L4.3 16.9A1.65 1.65 0 0 0 4 15C3.6 14.3 2.9 13.9 2.1 13.9H1.9V10.1H2.1C2.9 10.1 3.6 9.7 4 9C4.3 8.3 4.2 7.5 3.9 6.9L3.8 6.7L6.5 4L6.7 4.1C7.3 4.5 8.1 4.6 8.8 4.2C9.5 3.9 9.9 3.2 9.9 2.4V2.2H13.7V2.4C13.7 3.2 14.1 3.9 14.8 4.2C15.5 4.6 16.3 4.5 16.9 4.1L17.1 4L19.8 6.7L19.7 6.9C19.4 7.5 19.3 8.3 19.6 9C20 9.7 20.7 10.1 21.5 10.1H21.7V13.9H21.5C20.7 13.9 20 14.3 19.4 15Z"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>

                        </span>

                        <span class="sipper-nav-label">
                            Pengaturan Sistem
                        </span>

                    </a>

                </nav>

            </div>

        @endif

    </div>


    {{-- =====================================================
        USER PROFILE + LOGOUT
        BAGIAN INI SELALU DI BAWAH
        TIDAK IKUT SCROLL MENU
    ====================================================== --}}
    <div class="sipper-sidebar-bottom">

        {{-- User --}}
        <a
            href="{{ route('profile.show') }}"
            class="sipper-user-profile"
        >

            <div class="sipper-avatar">

                <svg
                    viewBox="0 0 24 24"
                    fill="currentColor"
                >
                    <path
                        d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z"
                    />
                </svg>

            </div>


            <div class="sipper-user-info">

                <div class="sipper-user-name">
                    {{ $sidebarUser?->name ?? 'Administrator' }}
                </div>

                <div class="sipper-user-role">
                    {{ $sidebarIsAdmin ? 'Super Admin' : 'Petugas' }}
                </div>

            </div>


            <svg
                class="sipper-user-chevron"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
            >
                <path
                    d="M6 9L12 15L18 9"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>

        </a>


        {{-- =================================================
            LOGOUT
        ================================================== --}}
        <form
            method="POST"
            action="{{ route('logout') }}"
            class="sipper-logout-form"
        >

            @csrf

            <button
                type="submit"
                class="sipper-logout"
            >

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                >
                    <path
                        d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                    <path
                        d="M16 17L21 12L16 7"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                    <path
                        d="M21 12H9"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>

                <span>
                    Keluar
                </span>

            </button>

        </form>

    </div>

</aside>