@php
    $headerUser = auth()->user();
    $headerIsAdmin = strtolower($headerUser?->role ?? '') === 'admin';
@endphp

<header class="topbar">
    <div class="crumb">
        <span class="crumb-prefix">Sistem Rekap</span>
        <span class="crumb-separator">/</span>
        <strong class="crumb-current">{{ $pageTitle ?? 'Input Rekap' }}</strong>
    </div>

    <div class="top-actions">
        <span class="today">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" stroke-linecap="round" stroke-linejoin="round"/>
                <line x1="16" y1="2" x2="16" y2="6" stroke-linecap="round"/>
                <line x1="8" y1="2" x2="8" y2="6" stroke-linecap="round"/>
                <line x1="3" y1="10" x2="21" y2="10" stroke-linecap="round"/>
            </svg>
            {{ now()->translatedFormat('l, d F Y') }}
        </span>

        <div class="top-profile">
            <button
                type="button"
                class="top-profile-trigger"
                aria-expanded="false"
                aria-controls="top-profile-menu"
            >
                <span class="top-profile-avatar" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z" />
                    </svg>
                </span>
                <span class="top-profile-details">
                    <strong>{{ $headerUser?->name ?? 'Administrator' }}</strong>
                    <small>{{ $headerIsAdmin ? 'Super Admin' : 'Petugas' }}</small>
                </span>
                <svg class="top-profile-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path d="M6 9L12 15L18 9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>

            <div id="top-profile-menu" class="top-profile-menu" hidden>
                <a href="{{ route('profile.show') }}" class="top-profile-menu-link">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="top-profile-menu-link top-profile-logout">Logout</button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
    (() => {
        const profile = document.querySelector('.top-profile');
        const trigger = profile?.querySelector('.top-profile-trigger');
        const menu = profile?.querySelector('.top-profile-menu');

        if (!profile || !trigger || !menu) return;

        const closeMenu = () => {
            menu.hidden = true;
            trigger.setAttribute('aria-expanded', 'false');
        };

        trigger.addEventListener('click', () => {
            const isOpen = !menu.hidden;
            menu.hidden = isOpen;
            trigger.setAttribute('aria-expanded', String(!isOpen));
        });

        document.addEventListener('click', (event) => {
            if (!profile.contains(event.target)) closeMenu();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') closeMenu();
        });
    })();
</script>
