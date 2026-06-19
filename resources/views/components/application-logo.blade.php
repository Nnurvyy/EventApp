<svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <!-- Soft background gradient -->
    <rect x="5" y="5" width="110" height="110" rx="32" fill="url(#cuteGrad)" />
    
    <!-- Calendar body -->
    <rect x="25" y="38" width="70" height="58" rx="16" fill="#ffffff" />
    <!-- Calendar header bar -->
    <path d="M25 54c0-8.837 7.163-16 16-16h38c8.837 0 16 7.163 16 16v4H25v-4z" fill="#0f766e" />
    
    <!-- Binder rings -->
    <rect x="40" y="26" width="8" height="16" rx="4" fill="#cbd5e1" />
    <rect x="72" y="26" width="8" height="16" rx="4" fill="#cbd5e1" />
    
    <!-- Smiley Face -->
    <!-- Eyes -->
    <circle cx="48" cy="70" r="4.5" fill="#1e293b" />
    <circle cx="72" cy="70" r="4.5" fill="#1e293b" />
    <!-- Cheeks (Blush) -->
    <circle cx="41" cy="75" r="5" fill="#a7f3d0" opacity="0.8" />
    <circle cx="79" cy="75" r="5" fill="#a7f3d0" opacity="0.8" />
    <!-- Smile -->
    <path d="M56 75c0 2.21 1.79 4 4 4s4-1.79 4-4" stroke="#1e293b" stroke-width="3" stroke-linecap="round" fill="none" />
    
    <!-- Cute little sparkling star -->
    <path d="M85 46l2 4 4 2-4 2-2 4-2-4-4-2 4-2z" fill="#2dd4bf" />

    <!-- Gradient definition -->
    <defs>
        <linearGradient id="cuteGrad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#a7f3d0" />
            <stop offset="100%" stop-color="#cffafe" />
        </linearGradient>
    </defs>
</svg>
