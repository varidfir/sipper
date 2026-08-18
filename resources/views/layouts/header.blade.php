<header class="topbar">
    <div class="crumb">
        Sistem Rekap <span style="margin: 0 8px; color: #cbd5e1;">/</span> 
        <strong>{{ $pageTitle ?? 'Input Rekap' }}</strong>
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
    </div>
</header>
